<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailPenerimaan extends Model
{
    protected $table = 'detail_penerimaan';
    protected $primaryKey = 'iddetail_penerimaan';
    public $timestamps = false;

    // Ambil semua item untuk satu penerimaan
    public static function getItemsByPenerimaanId($idpenerimaan)
    {
        $sql = "
            SELECT 
                dp.iddetail_penerimaan,
                dp.idpenerimaan,
                dp.barang_idbarang,
                b.nama AS nama_barang,
                s.nama_satuan,
                dp.jumlah_terima,
                dp.harga_satuan_terima,
                dp.sub_total_terima
            FROM detail_penerimaan dp
            JOIN barang b ON dp.barang_idbarang = b.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE dp.idpenerimaan = ?
            ORDER BY dp.iddetail_penerimaan ASC
        ";
        return DB::select($sql, [$idpenerimaan]);
    }

    // ✨ Ambil detail pengadaan dengan info sudah diterima berapa
    public static function getItemsForPenerimaan($idpengadaan)
    {
        $sql = "
            SELECT 
                dp.idbarang,
                b.nama AS nama_barang,
                s.nama_satuan,
                dp.jumlah AS jumlah_pesan,
                dp.harga_satuan AS harga_pengadaan,
                COALESCE(SUM(dpr.jumlah_terima), 0) AS sudah_diterima,
                (dp.jumlah - COALESCE(SUM(dpr.jumlah_terima), 0)) AS sisa_belum_diterima
            FROM detail_pengadaan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            LEFT JOIN penerimaan pr ON pr.idpengadaan = dp.idpengadaan
            LEFT JOIN detail_penerimaan dpr ON dpr.idpenerimaan = pr.idpenerimaan 
                AND dpr.barang_idbarang = dp.idbarang
            WHERE dp.idpengadaan = ?
            GROUP BY dp.idbarang, b.nama, s.nama_satuan, dp.jumlah, dp.harga_satuan
            HAVING sisa_belum_diterima > 0
            ORDER BY b.nama ASC
        ";
        return DB::select($sql, [$idpengadaan]);
    }

    // ✨ INSERT DETAIL PENERIMAAN
    public static function addItem($idpenerimaan, $idbarang, $jumlah_terima, $harga_satuan_terima)
    {
        $sub_total = $jumlah_terima * $harga_satuan_terima;
        
        $sql = "
            INSERT INTO detail_penerimaan 
            (idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima)
            VALUES (?, ?, ?, ?, ?)
        ";
        
        return DB::insert($sql, [$idpenerimaan, $idbarang, $jumlah_terima, $harga_satuan_terima, $sub_total]);
    }
}