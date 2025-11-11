<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailPenerimaan extends Model
{
    protected $table = 'detail_penerimaan';
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
            LEFT JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE dp.idpenerimaan = ?
        ";
        return DB::select($sql, [$idpenerimaan]);
    }
}
