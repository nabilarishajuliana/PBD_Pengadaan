CREATE DATABASE pbd_app;
USE pbd_app;

CREATE TABLE role (
  idrole INT AUTO_INCREMENT PRIMARY KEY,
  nama_role VARCHAR(100) NOT NULL
) ;

DESC role;

CREATE TABLE user (
  iduser INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(45) NOT NULL,
  password VARCHAR(100) NOT NULL,
  idrole INT NOT NULL,
  CONSTRAINT fk_user_role
    FOREIGN KEY (idrole) REFERENCES role(idrole)
) ;
DESC user;


CREATE TABLE vendor (
  idvendor INT AUTO_INCREMENT PRIMARY KEY,
  nama_vendor VARCHAR(100) NOT NULL,
  badan_hukum CHAR(1) NOT NULL, -- P: PT, C: CV, dll
  status CHAR(1) NOT NULL DEFAULT 'A' -- A: Aktif
);
DESC vendor;

CREATE TABLE satuan (
  idsatuan INT AUTO_INCREMENT PRIMARY KEY,
  nama_satuan VARCHAR(45) NOT NULL,
  status TINYINT NOT NULL DEFAULT 1 -- 1: Aktif
) ;
DESC satuan;



CREATE TABLE margin_penjualan (
  idmargin_penjualan INT AUTO_INCREMENT PRIMARY KEY,
  persen DOUBLE NOT NULL,
  status TINYINT NOT NULL DEFAULT 1, -- 1: Aktif
  iduser INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_margin_user
    FOREIGN KEY (iduser) REFERENCES user(iduser)
) ;
DESC margin_penjualan;

CREATE TABLE barang (
  idbarang INT AUTO_INCREMENT PRIMARY KEY,
  jenis CHAR(1) NOT NULL, 
  nama VARCHAR(45) NOT NULL,
  idsatuan INT NOT NULL,
  status TINYINT NOT NULL DEFAULT 1, -- 1: Aktif
  harga INT NOT NULL,
  CONSTRAINT fk_barang_satuan
    FOREIGN KEY (idsatuan) REFERENCES satuan(idsatuan)
) ;
DESC barang;

CREATE TABLE pengadaan (
  idpengadaan BIGINT PRIMARY KEY,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  user_iduser INT NOT NULL,
  status CHAR(1) NOT NULL , -- D: Draft, p: proses, dll
  vendor_idvendor INT NOT NULL,
  subtotal_nilai INT NOT NULL ,
  ppn INT NOT NULL,
  total_nilai INT NOT NULL ,
  CONSTRAINT fk_pengadaan_user
    FOREIGN KEY (user_iduser) REFERENCES user(iduser),
  CONSTRAINT fk_pengadaan_vendor
    FOREIGN KEY (vendor_idvendor) REFERENCES vendor(idvendor)
) ;
DESC pengadaan;

CREATE TABLE detail_pengadaan (
  iddetail_pengadaan BIGINT PRIMARY KEY,
  harga_satuan INT NOT NULL,
  jumlah INT NOT NULL,
  sub_total INT NOT NULL,
  idbarang INT NOT NULL,
  idpengadaan BIGINT NOT NULL,
  CONSTRAINT fk_detpeng_barang
    FOREIGN KEY (idbarang) REFERENCES barang(idbarang),
  CONSTRAINT fk_detpeng_pengadaan
    FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan)
);
DESC detail_pengadaan;


CREATE TABLE penerimaan (
  idpenerimaan BIGINT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status CHAR(1) NOT NULL , 
  idpengadaan BIGINT NOT NULL,
  iduser INT NOT NULL,
  CONSTRAINT fk_penerimaan_pengadaan
    FOREIGN KEY (idpengadaan) REFERENCES pengadaan(idpengadaan),
  CONSTRAINT fk_penerimaan_user
    FOREIGN KEY (iduser) REFERENCES user(iduser)
);
DESC penerimaan;


CREATE TABLE detail_penerimaan (
  iddetail_penerimaan BIGINT AUTO_INCREMENT PRIMARY KEY,
  idpenerimaan BIGINT NOT NULL,
  barang_idbarang INT NOT NULL,
  jumlah_terima INT NOT NULL,
  harga_satuan_terima INT NOT NULL,
  sub_total_terima INT NOT NULL,
  CONSTRAINT fk_detterima_penerimaan
    FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
  CONSTRAINT fk_detterima_barang
    FOREIGN KEY (barang_idbarang) REFERENCES barang(idbarang)
) ;
DESC detail_penerimaan;


CREATE TABLE penjualan (
  idpenjualan INT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  subtotal_nilai INT NOT NULL ,
  ppn INT NOT NULL ,
  total_nilai INT NOT NULL ,
  iduser INT NOT NULL,
  idmargin_penjualan INT NOT NULL,
  CONSTRAINT fk_penjualan_user
    FOREIGN KEY (iduser) REFERENCES user(iduser),
  CONSTRAINT fk_penjualan_margin
    FOREIGN KEY (idmargin_penjualan) REFERENCES margin_penjualan(idmargin_penjualan)
) ;
DESC penjualan;


CREATE TABLE detail_penjualan (
  iddetail_penjualan BIGINT AUTO_INCREMENT PRIMARY KEY,
  harga_satuan INT NOT NULL,
  jumlah INT NOT NULL,
  subtotal INT NOT NULL,
  penjualan_idpenjualan INT NOT NULL,
  idbarang INT NOT NULL,
  CONSTRAINT fk_detjual_penjualan
    FOREIGN KEY (penjualan_idpenjualan) REFERENCES penjualan(idpenjualan),
  CONSTRAINT fk_detjual_barang
    FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
) ;
DESC detail_penjualan;


CREATE TABLE `retur`(
  idretur BIGINT AUTO_INCREMENT PRIMARY KEY,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  idpenerimaan BIGINT NOT NULL,
  iduser INT NOT NULL,
  CONSTRAINT fk_retur_penerimaan
    FOREIGN KEY (idpenerimaan) REFERENCES penerimaan(idpenerimaan),
  CONSTRAINT fk_retur_user
    FOREIGN KEY (iduser) REFERENCES user(iduser)
);
DESC `retur`;


CREATE TABLE detail_retur (
  iddetail_retur INT AUTO_INCREMENT PRIMARY KEY,
  jumlah INT NOT NULL,
  alasan VARCHAR(200) NOT NULL,
  idretur BIGINT NOT NULL,
  iddetail_penerimaan BIGINT NOT NULL,
  CONSTRAINT fk_detretur_retur
    FOREIGN KEY (idretur) REFERENCES `retur`(idretur),
  CONSTRAINT fk_detretur_detpenerimaan
    FOREIGN KEY (iddetail_penerimaan) REFERENCES detail_penerimaan(iddetail_penerimaan)
) ;
DESC detail_retur;

CREATE TABLE kartu_stok (
  idkartu_stok BIGINT AUTO_INCREMENT PRIMARY KEY,
  jenis_transaksi CHAR(1) NOT NULL, -- T: Penerimaan, J: Penjualan, R: Retur, dll
  masuk INT NOT NULL,
  keluar INT NOT NULL ,
  stock INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  idtransaksi BIGINT NOT NULL,
  idbarang INT NOT NULL,
  CONSTRAINT fk_kartustok_barang
    FOREIGN KEY (idbarang) REFERENCES barang(idbarang)
) ;
DESC kartu_stok;

-- DML

INSERT INTO role (nama_role) VALUES
('admin'),
('superAdmin');

select * from role;


INSERT INTO user (username, password, idrole) VALUES
('renjun', '123456', 2),
('jisung', '123456', 1),
('jeno', '123456', 1),
('lele', '123456', 1),
('risha', '123456', 2);
select * from user;


INSERT INTO vendor (nama_vendor, badan_hukum, status) VALUES
('PT Sumber Makmur', 'P', 'A'), -- p=pt
('CV Maju Jaya', 'C', 'A'), -- c=cv
('PT Bumi Sejahtera', 'P', 'A'),
('UD Tani Subur', 'U', 'A'), -- u=usaha dagang
('PT Indo Supplies', 'P', 'A');
select * from vendor;


INSERT INTO satuan (nama_satuan, status) VALUES
('Pcs', 1), -- 1=aktif
('Box', 1),
('Kg', 1),
('Liter', 1),
('Pack', 1);
select * from satuan;

INSERT INTO barang (jenis, nama, idsatuan, status,harga) VALUES
('B', 'Gula Pasir', 3, 1,4000), -- b= bahan baku
('B', 'Tepung Terigu', 3, 1,4000),
('J', 'Roti Tawar', 1, 1,15000), -- j= barang jadi
('J', 'Kue Bolu', 1, 1,30000),
('B', 'Minyak Goreng', 4, 1,10000);
select * from barang;


INSERT INTO margin_penjualan (persen, status, iduser) VALUES
(10.0, 1, 1), -- status= 1->aktif
(15.0, 1, 1),
(20.0, 1, 1),
(25.0, 1, 1),
(30.0, 1, 1);
select * from margin_penjualan;


-- View Barang (dengan nama satuan)
CREATE OR REPLACE VIEW v_barang AS
SELECT 
    b.idbarang,
    b.nama AS nama_barang,
    b.jenis,
    s.nama_satuan,
    b.harga,
    b.status
FROM barang b
JOIN satuan s ON b.idsatuan = s.idsatuan
WHERE b.status = 1;


-- View Satuan (yang masih aktif)
CREATE OR REPLACE VIEW v_satuan AS
SELECT 
    idsatuan,
    nama_satuan,
    status
FROM satuan
WHERE status = 1;

-- View Vendor (data vendor aktif)
CREATE OR REPLACE VIEW v_vendor AS
SELECT 
    idvendor,
    nama_vendor,
    badan_hukum,
    status
FROM vendor
WHERE status = 'A';

-- View User (dengan nama role)
CREATE OR REPLACE VIEW v_user AS
SELECT 
    u.iduser,
    u.username,
    r.nama_role
FROM user u
JOIN role r ON u.idrole = r.idrole;

-- View Margin Penjualan (dengan nama user pembuat dan status aktif)
CREATE OR REPLACE VIEW v_margin_penjualan AS
SELECT 
    m.idmargin_penjualan,
    m.persen,
    m.status,
    u.username AS dibuat_oleh,
    m.created_at,
    m.updated_at
FROM margin_penjualan m
JOIN user u ON m.iduser = u.iduser
WHERE m.status = 1;

CREATE OR REPLACE VIEW v_barang_all AS
SELECT 
    b.idbarang,
    b.nama AS nama_barang,
    b.jenis,
    s.nama_satuan,
    b.harga,
    b.status
FROM barang b
JOIN satuan s ON b.idsatuan = s.idsatuan;

CREATE OR REPLACE VIEW v_satuan_all AS
SELECT 
    idsatuan,
    nama_satuan,
    status
FROM satuan;

CREATE OR REPLACE VIEW v_vendor_all AS
SELECT 
    idvendor,
    nama_vendor,
    badan_hukum,
    status
FROM vendor;

CREATE OR REPLACE VIEW v_margin_penjualan_all AS
SELECT 
    m.idmargin_penjualan,
    m.persen,
    m.status,
    u.username AS dibuat_oleh,
    m.created_at,
    m.updated_at
FROM margin_penjualan m
JOIN user u ON m.iduser = u.iduser;

CREATE OR REPLACE VIEW v_role AS
SELECT 
    idrole,
    nama_role
FROM role;

SELECT * FROM v_barang;

SHOW FULL TABLES WHERE TABLE_TYPE = 'VIEW';



-- -- STORE PROCEDURE
-- DELIMITER $$

-- CREATE PROCEDURE sp_update_harga(
--     IN p_idbarang INT,
--     IN p_harga_baru INT
-- )
-- BEGIN
--     UPDATE barang 
--     SET harga = p_harga_baru 
--     WHERE idbarang = p_idbarang;
-- END$$

-- DELIMITER ;

-- call sp_update_harga();

-- -- FUNCTION
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_hitung_harga_jual$$
-- CREATE FUNCTION fn_hitung_harga_jual(p_idbarang INT)
-- RETURNS INT
-- READS SQL DATA
-- BEGIN
--     DECLARE v_harga_beli INT DEFAULT 0;
--     DECLARE v_persen_margin DECIMAL(5,2) DEFAULT 0;
--     DECLARE v_harga_jual INT DEFAULT 0;

--     -- 1️⃣ Ambil margin aktif (pakai backtick biar aman)
--     SELECT COALESCE(persen, 0)
--     INTO v_persen_margin
--     FROM margin_penjualan
--     WHERE `status` = 1
--     ORDER BY idmargin_penjualan DESC
--     LIMIT 1;

--     -- 2️⃣ Ambil harga barang
--     SELECT COALESCE(harga, 0)
--     INTO v_harga_beli
--     FROM barang
--     WHERE idbarang = p_idbarang
--     LIMIT 1;

--     -- 3️⃣ Hitung harga jual
--     SET v_harga_jual = ROUND(v_harga_beli + (v_harga_beli * v_persen_margin / 100));

--     -- 4️⃣ Return hasil
--     RETURN v_harga_jual;
-- END$$

-- DELIMITER ;

-- -- 2.function buat hitung sub total pengadaan 
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_total_pengadaan$$
-- CREATE FUNCTION fn_total_pengadaan(p_idpengadaan INT)
-- RETURNS DECIMAL(15,2)
-- READS SQL DATA
-- BEGIN
--     DECLARE v_total DECIMAL(15,2);

--     SELECT COALESCE(SUM(sub_total), 0)
--     INTO v_total
--     FROM detail_pengadaan
--     WHERE idpengadaan = p_idpengadaan;

--     RETURN v_total;
-- END$$

-- DELIMITER ;

-- -- 3. function buat hitung ppn (10%)
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_hitung_ppn$$
-- CREATE FUNCTION fn_hitung_ppn(p_subtotal DECIMAL(15,2))
-- RETURNS DECIMAL(15,2)
-- DETERMINISTIC
-- BEGIN
--     RETURN ROUND(p_subtotal * 0.10, 2);
-- END$$

-- DELIMITER ;



-- -- 4. function hitung semua total nilai (+ppn)
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_hitung_total_pengadaan$$
-- CREATE FUNCTION fn_hitung_total_pengadaan(p_subtotal DECIMAL(15,2))
-- RETURNS DECIMAL(15,2)
-- DETERMINISTIC
-- BEGIN
--     RETURN ROUND(p_subtotal + fn_hitung_ppn(p_subtotal), 2);
-- END$$

-- DELIMITER ;


-- SELECT fn_hitung_ppn(500000) as "ppn";

-- -- 5. function hitung sub total penjualan
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_total_penjualan$$
-- CREATE FUNCTION fn_total_penjualan(p_idpenjualan INT)
-- RETURNS DECIMAL(15,2)
-- READS SQL DATA
-- BEGIN
--     DECLARE v_total DECIMAL(15,2);

--     SELECT COALESCE(SUM(subtotal), 0)
--     INTO v_total
--     FROM detail_penjualan
--     WHERE penjualan_idpenjualan = p_idpenjualan;

--     RETURN v_total;
-- END$$

-- DELIMITER ;

-- -- 6. function hitung ppn penjualan
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_hitung_ppn_penjualan$$
-- CREATE FUNCTION fn_hitung_ppn_penjualan(p_subtotal DECIMAL(15,2))
-- RETURNS DECIMAL(15,2)
-- DETERMINISTIC
-- BEGIN
--     RETURN ROUND(p_subtotal * 0.11, 2);
-- END$$

-- DELIMITER ;

-- -- 7. hitung total niali penjualan +ppn
-- DELIMITER $$

-- DROP FUNCTION IF EXISTS fn_hitung_total_penjualan$$
-- CREATE FUNCTION fn_hitung_total_penjualan(p_subtotal DECIMAL(15,2))
-- RETURNS DECIMAL(15,2)
-- DETERMINISTIC
-- BEGIN
--     RETURN ROUND(p_subtotal + fn_hitung_ppn_penjualan(p_subtotal), 2);
-- END$$

-- DELIMITER ;

-- -- 2. SP Update Nilai & Status Pengadaan
-- DELIMITER $$

-- DROP PROCEDURE IF EXISTS sp_update_nilai_pengadaan$$
-- CREATE PROCEDURE sp_update_nilai_pengadaan(IN p_idpengadaan INT)
-- BEGIN
--     DECLARE v_subtotal DECIMAL(15,2);
--     DECLARE v_ppn DECIMAL(15,2);
--     DECLARE v_total DECIMAL(15,2);

--     -- Hitung subtotal
--     SET v_subtotal = fn_total_pengadaan(p_idpengadaan);

--     -- Hitung ppn dan total
--     SET v_ppn = fn_hitung_ppn(v_subtotal);
--     SET v_total = fn_hitung_total_pengadaan(v_subtotal);

--     -- Update tabel pengadaan
--     UPDATE pengadaan
--     SET subtotal_nilai = v_subtotal,
--         ppn = v_ppn,
--         total_nilai = v_total
--     WHERE idpengadaan = p_idpengadaan;
-- END$$

-- DELIMITER ;

-- -- 3. SP update nilai ke penjualan
-- DELIMITER $$

-- DROP PROCEDURE IF EXISTS sp_update_nilai_penjualan$$
-- CREATE PROCEDURE sp_update_nilai_penjualan(IN p_idpenjualan INT)
-- BEGIN
--     DECLARE v_subtotal DECIMAL(15,2);
--     DECLARE v_ppn DECIMAL(15,2);
--     DECLARE v_total DECIMAL(15,2);

--     -- Hitung subtotal
--     SET v_subtotal = fn_total_penjualan(p_idpenjualan);

--     -- Hitung ppn dan total
--     SET v_ppn = fn_hitung_ppn_penjualan(v_subtotal);
--     SET v_total = fn_hitung_total_penjualan(v_subtotal);

--     -- Update tabel penjualan
--     UPDATE penjualan
--     SET subtotal_nilai = v_subtotal,
--         ppn = v_ppn,
--         total_nilai = v_total
--     WHERE idpenjualan = p_idpenjualan;
-- END$$

-- DELIMITER ;


-- -- TRIGGER

-- -- trigger after DETAIL PENGADAAN 
-- DELIMITER $$

-- DROP TRIGGER IF EXISTS tr_after_insert_detail_pengadaan$$
-- CREATE TRIGGER tr_after_insert_detail_pengadaan
-- AFTER INSERT ON detail_pengadaan
-- FOR EACH ROW
-- BEGIN
--     CALL sp_update_nilai_pengadaan(NEW.idpengadaan);
-- END$$

-- DELIMITER ;


-- -- trigger after DETAIL PENERIMAAN
-- DELIMITER $$

-- DROP TRIGGER IF EXISTS tr_kartustok_after_insert_detail_penerimaan$$

-- -- CREATE TRIGGER tr_kartustok_after_insert_detail_penerimaan
-- -- AFTER INSERT ON detail_penerimaan
-- -- FOR EACH ROW
-- -- BEGIN
-- --   DECLARE v_current_stock INT DEFAULT 0;
-- --   DECLARE v_new_stock INT DEFAULT 0;

-- --   -- hitung stock sekarang (sebelum entry baru)
-- --   SELECT COALESCE(SUM(masuk) - SUM(keluar), 0)
-- --     INTO v_current_stock
-- --     FROM kartu_stok
-- --     WHERE idbarang = NEW.barang_idbarang;

-- --   -- new stock setelah penerimaan
-- --   SET v_new_stock = v_current_stock + NEW.jumlah_terima;

-- --   INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang, created_at)
-- --   VALUES ('M', NEW.jumlah_terima, 0, v_new_stock, NEW.idpenerimaan, NEW.barang_idbarang, NOW());
-- -- END$$

-- DELIMITER ;

-- -- trigger after DETAIL PENJUALAN
-- DELIMITER $$
-- DROP TRIGGER IF EXISTS tr_after_insert_detail_penjualan$$
-- CREATE TRIGGER tr_after_insert_detail_penjualan
-- AFTER INSERT ON detail_penjualan
-- FOR EACH ROW
-- BEGIN
--     
-- 	DECLARE v_current_stock INT DEFAULT 0;
-- 	DECLARE v_new_stock INT DEFAULT 0;
-- 	
--     -- 1️⃣ Hitung stok akhir barang di kartu_stok
-- 	SELECT COALESCE(SUM(masuk) - SUM(keluar), 0)
--     INTO v_current_stock
--     FROM kartu_stok
--     WHERE idbarang = NEW.idbarang;

-- 	-- Jika kamu ingin cegah stock negatif, aktifkan pengecekan berikut:
-- 	IF v_current_stock < NEW.jumlah THEN
--      SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak cukup untuk penjualan';
-- 	END IF;

-- 	SET v_new_stock = v_current_stock - NEW.jumlah;
--   
-- 	-- 2️⃣ Tambahkan record baru ke kartu_stok (stok keluar karena penjualan)
-- 	INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang, created_at)
-- 	VALUES ('K', 0, NEW.jumlah, v_new_stock, NEW.penjualan_idpenjualan, NEW.idbarang, NOW());

--     -- 3️⃣ Update nilai subtotal, PPN, dan total di tabel penjualan
--     CALL sp_update_nilai_penjualan(NEW.penjualan_idpenjualan);
-- END$$

-- DELIMITER ;


-- -- triger after DETAIL RETUR
-- DELIMITER $$
-- -- pas ada retur (stok berkurang karna barang dari penerimaan dikembalikan,bukan barang penjualan di kembalikan ke kita) 
-- DROP TRIGGER IF EXISTS tr_kartustok_after_insert_detail_retur$$

-- -- CREATE TRIGGER tr_kartustok_after_insert_detail_retur
-- -- AFTER INSERT ON detail_retur
-- -- FOR EACH ROW
-- -- BEGIN
-- --   DECLARE v_idbarang INT;
-- --   DECLARE v_jumlah INT;
-- --   DECLARE v_current_stock INT DEFAULT 0;
-- --   DECLARE v_new_stock INT DEFAULT 0;

-- --   -- Ambil idbarang dari detail_penerimaan yang diretur
-- --   SELECT barang_idbarang
-- --   INTO v_idbarang
-- --   FROM detail_penerimaan
-- --   WHERE iddetail_penerimaan = NEW.iddetail_penerimaan;

-- --   -- Ambil jumlah barang yang diretur
-- --   SET v_jumlah = NEW.jumlah;

-- --   -- Hitung stok sekarang
-- --   SELECT COALESCE(SUM(masuk) - SUM(keluar), 0)
-- --   INTO v_current_stock
-- --   FROM kartu_stok
-- --   WHERE idbarang = v_idbarang;

-- --   -- Barang keluar dari stok karena dikembalikan ke vendor
-- --   SET v_new_stock = v_current_stock - v_jumlah;

-- --   -- Insert ke kartu_stok
-- --   INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, idtransaksi, idbarang, created_at)
-- --   VALUES ('R', 0, v_jumlah, v_new_stock, NEW.idretur, v_idbarang, NOW());
-- -- END$$

-- DELIMITER ;




