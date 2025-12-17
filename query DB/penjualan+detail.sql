-- function total penjualan
DELIMITER $$

DROP FUNCTION IF EXISTS fn_total_penjualan$$
CREATE FUNCTION fn_total_penjualan(p_idpenjualan INT)
RETURNS DECIMAL(15,2)
READS SQL DATA
BEGIN
    DECLARE v_total DECIMAL(15,2);
    SELECT COALESCE(SUM(subtotal), 0)
    INTO v_total
    FROM detail_penjualan
    WHERE penjualan_idpenjualan = p_idpenjualan;
    RETURN v_total;
END$$

DELIMITER ;

-- function ppn penjualan
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_ppn_penjualan$$
CREATE FUNCTION fn_hitung_ppn_penjualan(p_subtotal DECIMAL(15,2))
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    RETURN ROUND(p_subtotal * 0.10, 2);
END$$

DELIMITER ;

-- function total penjualan + ppn
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_total_penjualan$$
CREATE FUNCTION fn_hitung_total_penjualan(p_subtotal DECIMAL(15,2))
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    RETURN ROUND(p_subtotal + fn_hitung_ppn_penjualan(p_subtotal), 2);
END$$

DELIMITER ;

-- sp update penjualan
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_update_nilai_penjualan$$
CREATE PROCEDURE sp_update_nilai_penjualan(IN p_idpenjualan INT)
BEGIN
    DECLARE v_subtotal DECIMAL(15,2);
    DECLARE v_ppn DECIMAL(15,2);
    DECLARE v_total DECIMAL(15,2);

    -- Hitung nilai
    SET v_subtotal = fn_total_penjualan(p_idpenjualan);
    SET v_ppn = fn_hitung_ppn_penjualan(v_subtotal);
    SET v_total = fn_hitung_total_penjualan(v_subtotal);

    -- Update tabel penjualan
    UPDATE penjualan
    SET subtotal_nilai = v_subtotal,
        ppn = v_ppn,
        total_nilai = v_total
    WHERE idpenjualan = p_idpenjualan;
END$$

DELIMITER ;

-- triger after detail penjualan
DELIMITER $$

DROP TRIGGER IF EXISTS tr_after_insert_detail_penjualan$$
CREATE TRIGGER tr_after_insert_detail_penjualan
AFTER INSERT ON detail_penjualan
FOR EACH ROW
BEGIN
    DECLARE v_current_stock INT DEFAULT 0;
    DECLARE v_new_stock INT DEFAULT 0;

    -- 1️⃣ Hitung stok saat ini dari kartu_stok
    SELECT COALESCE(SUM(masuk) - SUM(keluar), 0)
    INTO v_current_stock
    FROM kartu_stok
    WHERE idbarang = NEW.idbarang;

    -- 2️⃣ Cegah stok negatif
    IF v_current_stock < NEW.jumlah THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stok barang  tidak cukup untuk penjualan.';
    END IF;

    -- 3️⃣ Hitung stok baru
    SET v_new_stock = v_current_stock - NEW.jumlah;

    -- 4️⃣ Catat transaksi di kartu_stok
    INSERT INTO kartu_stok (idbarang, jenis_transaksi, masuk, keluar, stock, idtransaksi, created_at)
    VALUES (NEW.idbarang, 'K', 0, NEW.jumlah, v_new_stock, NEW.penjualan_idpenjualan, NOW());

    -- 5️⃣ Panggil SP untuk update subtotal, PPN, dan total nilai penjualan
    CALL sp_update_nilai_penjualan(NEW.penjualan_idpenjualan);
END$$

DELIMITER ;

INSERT INTO penjualan (iduser, idmargin_penjualan, created_at, subtotal_nilai, ppn, total_nilai)
VALUES (1, (SELECT idmargin_penjualan FROM margin_penjualan WHERE status = 1 LIMIT 1), NOW(), 0, 0, 0);

SET @id_penjualan := LAST_INSERT_ID();

-- Tambahkan detail penjualan (barang 1 dan 2)
INSERT INTO detail_penjualan (penjualan_idpenjualan, idbarang, jumlah, harga_satuan, subtotal)
VALUES 
(@id_penjualan, 1, 5, fn_hitung_harga_jual(1), 5 * fn_hitung_harga_jual(1)),  -- Gula 5 unit
(@id_penjualan, 2, 3, fn_hitung_harga_jual(2), 3 * fn_hitung_harga_jual(2));  -- Tepung 3 unit

