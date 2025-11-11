<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailRetur extends Model
{
    protected $table = 'detail_retur';
    public $timestamps = false;

    // Ambil semua detail berdasarkan idretur
    public static function getByReturId($idretur)
    {
        $sql = "SELECT dr.iddetail_retur, dr.idretur, dr.jumlah, 
                       dp.iddetail_penerimaan, p.idpenerimaan, 
                       b.nama AS nama_barang
                FROM detail_retur dr
                JOIN detail_penerimaan dp ON dr.iddetail_penerimaan = dp.iddetail_penerimaan
                JOIN penerimaan p ON dp.idpenerimaan = p.idpenerimaan
                JOIN barang b ON dp.barang_idbarang = b.idbarang
                WHERE dr.idretur = ?
                ORDER BY dr.iddetail_retur ASC";
        return DB::select($sql, [$idretur]);
    }
}
