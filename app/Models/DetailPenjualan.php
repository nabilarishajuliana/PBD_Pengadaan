<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualan';
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
                dp.harga_satuan,
                dp.jumlah,
                dp.subtotal
            FROM detail_penjualan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            LEFT JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE dp.penjualan_idpenjualan = ?
        ";
        return DB::select($sql, [$idpenjualan]);
    }
}
