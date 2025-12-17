-- function hitung total retur
DELIMITER $$

DROP FUNCTION IF EXISTS fn_total_retur$$
CREATE FUNCTION fn_total_retur(p_iddetail_penerimaan INT)
RETURNS INT
READS SQL DATA
BEGIN
    DECLARE v_total INT DEFAULT 0;
    SELECT COALESCE(SUM(dr.jumlah), 0)
    INTO v_total
    FROM detail_retur dr
    WHERE dr.iddetail_penerimaan = p_iddetail_penerimaan;
    RETURN v_total;
END$$

DELIMITER ;

-- triger after detail retur
DELIMITER $$

DROP TRIGGER IF EXISTS tr_after_insert_detail_retur$$
CREATE TRIGGER tr_after_insert_detail_retur
AFTER INSERT ON detail_retur
FOR EACH ROW
BEGIN
    DECLARE v_idbarang INT;
    DECLARE v_jumlah_terima INT DEFAULT 0;
    DECLARE v_total_retur INT DEFAULT 0;
    DECLARE v_stok_akhir INT DEFAULT 0;

    -- 1️⃣ Ambil idbarang dan jumlah_terima dari detail_penerimaan
    SELECT barang_idbarang, jumlah_terima
    INTO v_idbarang, v_jumlah_terima
    FROM detail_penerimaan
    WHERE iddetail_penerimaan = NEW.iddetail_penerimaan
    LIMIT 1;

    -- 2️⃣ Hitung total retur sebelumnya (termasuk yang baru)
    SET v_total_retur = fn_total_retur(NEW.iddetail_penerimaan);

    -- 3️⃣ Validasi: tidak boleh lebih dari jumlah diterima
    IF v_total_retur > v_jumlah_terima THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Jumlah retur melebihi jumlah diterima untuk barang ';
    END IF;
    
  
    -- 4️⃣ Hitung stok akhir saat ini
    SELECT COALESCE(SUM(masuk) - SUM(keluar), 0)
    INTO v_stok_akhir
    FROM kartu_stok
    WHERE idbarang = v_idbarang;
     
     -- 2️⃣ Cegah stok negatif
    IF v_stok_akhir < NEW.jumlah THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stok barang  tidak cukup untuk retur.';
    END IF;

    -- 5️⃣ Kurangi stok di kartu_stok (barang keluar karena retur)
    INSERT INTO kartu_stok (idbarang, jenis_transaksi, masuk, keluar, stock, idtransaksi, created_at)
    VALUES (v_idbarang, 'R', 0, NEW.jumlah, v_stok_akhir - NEW.jumlah, NEW.idretur, NOW());
END$$

DELIMITER ;

-- 1️⃣ Buat retur header
INSERT INTO `retur` (idpenerimaan, iduser, created_at)
VALUES (1, 1, NOW());
SET @id_retur := LAST_INSERT_ID();

-- 2️⃣ Lihat detail penerimaan yang mau diretur
SELECT iddetail_penerimaan, barang_idbarang, jumlah_terima
FROM detail_penerimaan
WHERE idpenerimaan = 1;

-- Misal kita mau retur sebagian dari detail_penerimaan id=1
INSERT INTO detail_retur (idretur, iddetail_penerimaan, jumlah, alasan)
VALUES (@id_retur, 1, 2, 'Barang rusak');

-- 3️⃣ Cek efek di kartu_stok
SELECT * FROM kartu_stok
WHERE idbarang IN (SELECT barang_idbarang FROM detail_penerimaan WHERE idpenerimaan = 1)
ORDER BY created_at DESC;
