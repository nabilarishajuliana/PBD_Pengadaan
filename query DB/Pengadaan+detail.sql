use pbd_App;

-- 2.function buat hitung sub total pengadaan 
DELIMITER $$

DROP FUNCTION IF EXISTS fn_total_pengadaan$$
CREATE FUNCTION fn_total_pengadaan(p_idpengadaan INT)
RETURNS DECIMAL(15,2)
READS SQL DATA
BEGIN
    DECLARE v_total DECIMAL(15,2);

    SELECT COALESCE(SUM(sub_total), 0)
    INTO v_total
    FROM detail_pengadaan
    WHERE idpengadaan = p_idpengadaan;

    RETURN v_total;
END$$

DELIMITER ;

-- 3. function buat hitung ppn (10%)
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_ppn$$
CREATE FUNCTION fn_hitung_ppn(p_subtotal DECIMAL(15,2))
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    RETURN ROUND(p_subtotal * 0.10, 2);
END$$

DELIMITER ;



-- 4. function hitung semua total nilai (+ppn)
DELIMITER $$

DROP FUNCTION IF EXISTS fn_hitung_total_pengadaan$$
CREATE FUNCTION fn_hitung_total_pengadaan(p_subtotal DECIMAL(15,2))
RETURNS DECIMAL(15,2)
DETERMINISTIC
BEGIN
    RETURN ROUND(p_subtotal + fn_hitung_ppn(p_subtotal), 2);
END$$

DELIMITER ;

--  SP Update Nilai & Status Pengadaan
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_update_nilai_pengadaan$$
CREATE PROCEDURE sp_update_nilai_pengadaan(IN p_idpengadaan INT)
BEGIN
    DECLARE v_subtotal DECIMAL(15,2);
    DECLARE v_ppn DECIMAL(15,2);
    DECLARE v_total DECIMAL(15,2);

    -- Hitung subtotal
    SET v_subtotal = fn_total_pengadaan(p_idpengadaan);

    -- Hitung ppn dan total
    SET v_ppn = fn_hitung_ppn(v_subtotal);
    SET v_total = fn_hitung_total_pengadaan(v_subtotal);

    -- Update tabel pengadaan
    UPDATE pengadaan
    SET subtotal_nilai = v_subtotal,
        ppn = v_ppn,
        total_nilai = v_total
    WHERE idpengadaan = p_idpengadaan;
END$$

DELIMITER ;

-- trigger after detail pengadaan
DELIMITER $$

DROP TRIGGER IF EXISTS tr_after_insert_detail_pengadaan$$
CREATE TRIGGER tr_after_insert_detail_pengadaan
AFTER INSERT ON detail_pengadaan
FOR EACH ROW
BEGIN
    CALL sp_update_nilai_pengadaan(NEW.idpengadaan);
END$$

DELIMITER ;


-- TESTING

INSERT INTO pengadaan (vendor_idvendor, user_iduser, timestamp, status, subtotal_nilai, ppn, total_nilai)
VALUES (1, 1, NOW(), 'N', 0, 0, 0);

-- Ambil ID pengadaan terbaru
SET @id_pengadaan := LAST_INSERT_ID();

-- Tambah detail pengadaan
INSERT INTO detail_pengadaan (idpengadaan, idbarang, jumlah, harga_satuan, sub_total)
VALUES
(@id_pengadaan, 1, 50, (SELECT harga FROM barang WHERE idbarang = 1), 50 * (SELECT harga FROM barang WHERE idbarang = 1)),
(@id_pengadaan, 2, 30, (SELECT harga FROM barang WHERE idbarang = 2), 30 * (SELECT harga FROM barang WHERE idbarang = 2)),
(@id_pengadaan, 3, 10, (SELECT harga FROM barang WHERE idbarang = 3), 10 * (SELECT harga FROM barang WHERE idbarang = 3));



