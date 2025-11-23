<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'iddetail_penjualan';
    public $timestamps = false;

    // Ambil semua item untuk satu penjualan
    public static function getItemsByPenjualanId($idpenjualan)
    {
        $sql = "
            SELECT 
                dp.iddetail_penjualan,
                dp.penjualan_idpenjualan,
                dp.idbarang,
                b.nama AS nama_barang,
                s.nama_satuan,
                dp.jumlah,
                dp.harga_satuan,
                dp.subtotal,
                b.harga AS harga_beli
            FROM detail_penjualan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE dp.penjualan_idpenjualan = ?
            ORDER BY dp.iddetail_penjualan ASC
        ";
        return DB::select($sql, [$idpenjualan]);
    }

    // ✨ INSERT DETAIL PENJUALAN
    public static function addItem($idpenjualan, $idbarang, $jumlah, $harga_satuan)
    {
        $subtotal = $jumlah * $harga_satuan;
        
        $sql = "
            INSERT INTO detail_penjualan (penjualan_idpenjualan, idbarang, jumlah, harga_satuan, subtotal)
            VALUES (?, ?, ?, ?, ?)
        ";
        
        return DB::insert($sql, [$idpenjualan, $idbarang, $jumlah, $harga_satuan, $subtotal]);
    }
}