<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'idbarang';
    public $timestamps = false;

    // Ambil barang aktif untuk pengadaan (hanya bahan baku )
    public static function getActiveBarangForPengadaan()
    {
        $sql = "
            SELECT 
                b.idbarang,
                b.nama,
                b.harga,
                s.nama_satuan
            FROM barang b
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE b.status = 1 
            ORDER BY b.nama ASC
        ";
        return DB::select($sql);
    }

    // Get barang by ID
    public static function getBarangById($id)
    {
        $sql = "
            SELECT 
                b.idbarang,
                b.nama,
                b.harga,
                s.nama_satuan
            FROM barang b
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE b.idbarang = ?
            LIMIT 1
        ";
        $res = DB::select($sql, [$id]);
        return count($res) ? $res[0] : null;
    }

     // ✨ Ambil barang aktif untuk penjualan (semua jenis + stok)
    public static function getActiveBarangForPenjualan()
    {
        $sql = "
            SELECT 
                b.idbarang,
                b.nama,
                b.jenis,
                b.harga AS harga_beli,
                s.nama_satuan,
                COALESCE(
                    (SELECT SUM(k.masuk - k.keluar) 
                     FROM kartu_stok k 
                     WHERE k.idbarang = b.idbarang
                    ), 0
                ) AS stok_tersedia
            FROM barang b
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE b.status = 1
            HAVING stok_tersedia > 0
            ORDER BY b.nama ASC
        ";
        return DB::select($sql);
    }

}