use pbd_App;

-- function hitung total yg diterima
DELIMITER $$

DROP FUNCTION IF EXISTS fn_total_diterima$$
CREATE FUNCTION fn_total_diterima(p_idpengadaan INT, p_idbarang INT)
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE v_total INT DEFAULT 0;
    SELECT COALESCE(SUM(dp.jumlah_terima), 0)
    INTO v_total
    FROM detail_penerimaan dp
    JOIN penerimaan p ON p.idpenerimaan = dp.idpenerimaan
    WHERE p.idpengadaan = p_idpengadaan
      AND dp.barang_idbarang = p_idbarang;
    RETURN v_total;
END$$

DELIMITER ;

-- triger after detail penerimaan
DELIMITER $$

DROP TRIGGER IF EXISTS tr_after_insert_detail_penerimaan$$
CREATE TRIGGER tr_after_insert_detail_penerimaan
AFTER INSERT ON detail_penerimaan
FOR EACH ROW
BEGIN
    DECLARE v_idpengadaan INT;
    DECLARE v_jumlah_dipesan INT DEFAULT 0;
    DECLARE v_total_diterima INT DEFAULT 0;
    DECLARE v_stok_akhir INT DEFAULT 0;

    -- Ambil idpengadaan dari header penerimaan
    SELECT idpengadaan INTO v_idpengadaan
    FROM penerimaan
    WHERE idpenerimaan = NEW.idpenerimaan
    LIMIT 1;

    -- Jika tidak ditemukan idpengadaan (shouldn't happen), abort
    IF v_idpengadaan IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Header penerimaan tidak ditemukan untuk idpenerimaan';
    END IF;

    -- 1) Ambil jumlah barang yang dipesan dari detail_pengadaan (kolom: idbarang)
    SELECT jumlah INTO v_jumlah_dipesan
    FROM detail_pengadaan
    WHERE idpengadaan = v_idpengadaan
      AND idbarang = NEW.barang_idbarang
    LIMIT 1;

    IF v_jumlah_dipesan IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT ='Barang  tidak ditemukan di pengadaan ID' ;
    END IF;

    -- 2) Hitung total barang yang sudah diterima (termasuk yang baru)
    SET v_total_diterima = fn_total_diterima(v_idpengadaan, NEW.barang_idbarang);

    -- 3) Jika total diterima > jumlah pesan → tolak
    IF v_total_diterima > v_jumlah_dipesan THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Jumlah penerimaan barang ID melebihi jumlah pesanan';
    END IF;

    -- 4) Hitung stok akhir barang sekarang (dari kartu_stok)
    SELECT COALESCE(SUM(masuk) - SUM(keluar), 0)
    INTO v_stok_akhir
    FROM kartu_stok
    WHERE idbarang = NEW.barang_idbarang;

    -- 5) Tambah stok ke kartu_stok (barang masuk)
    INSERT INTO kartu_stok (idbarang, jenis_transaksi, masuk, keluar, stock, idtransaksi, created_at)
    VALUES (NEW.barang_idbarang, 'M', NEW.jumlah_terima, 0, v_stok_akhir + NEW.jumlah_terima, NEW.idpenerimaan, NOW());

    -- 6) Update harga beli barang sesuai harga terbaru di penerimaan
    UPDATE barang
    SET harga = NEW.harga_satuan_terima
    WHERE idbarang = NEW.barang_idbarang;

    -- 7) Jika semua barang pengadaan sudah diterima, ubah status pengadaan ke 'F'
    IF NOT EXISTS (
        SELECT 1
        FROM detail_pengadaan dp
        LEFT JOIN (
            SELECT p.idpengadaan, dp2.barang_idbarang, SUM(dp2.jumlah_terima) AS total_terima
            FROM penerimaan p
            JOIN detail_penerimaan dp2 ON dp2.idpenerimaan = p.idpenerimaan
            GROUP BY p.idpengadaan, dp2.barang_idbarang
        ) dpr ON dp.idbarang = dpr.barang_idbarang AND dp.idpengadaan = dpr.idpengadaan
        WHERE dp.idpengadaan = v_idpengadaan
          AND COALESCE(dpr.total_terima, 0) < dp.jumlah
    ) THEN
        UPDATE pengadaan
        SET status = 'F'
        WHERE idpengadaan = v_idpengadaan;
    END IF;
END$$

DELIMITER ;

-- 1. Buat pengadaan + detail_pengadaan (contoh)
INSERT INTO pengadaan (vendor_idvendor, user_iduser,timestamp, status, subtotal_nilai, ppn, total_nilai)
VALUES (1,1,NOW(), 'N',0,0,0);
SET @id_pengadaan := LAST_INSERT_ID();

INSERT INTO detail_pengadaan (idpengadaan, idbarang, jumlah, harga_satuan, sub_total)
VALUES (@id_pengadaan, 2, 10, (SELECT harga FROM barang WHERE idbarang=2), 10*(SELECT harga FROM barang WHERE idbarang=2));

-- 2. Buat penerimaan header
INSERT INTO penerimaan (idpengadaan, iduser, created_at, status)
VALUES (@id_pengadaan, 1, NOW(), 'F');
SET @id_penerimaan := LAST_INSERT_ID();

-- 3. Insert detail_penerimaan (partial)
INSERT INTO detail_penerimaan (idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima)
VALUES (@id_penerimaan, 2, 10, 5000, 10*5000);
-- seharusnya: stok bertambah +6, harga barang diupdate ke 4800

-- 4. Insert detail_penerimaan (sisa)
INSERT INTO detail_penerimaan (idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima)
VALUES (@id_penerimaan, 1, 4, 5000, 4*5000);
-- seharusnya: total received = 10 => pengadaan.status -> 'F'

