<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetailPengadaan extends Model
{
    protected $table = 'detail_pengadaan';
    public $timestamps = false;

    // Ambil semua item untuk satu pengadaan
    public static function getItemsByPengadaanId($idpengadaan)
    {
        $sql = "
            SELECT 
                dp.iddetail_pengadaan,
                dp.idpengadaan,
                dp.idbarang,
                b.nama AS nama_barang,
                s.nama_satuan,
                dp.jumlah,
                dp.harga_satuan,
                dp.sub_total
            FROM detail_pengadaan dp
            JOIN barang b ON dp.idbarang = b.idbarang
            JOIN satuan s ON b.idsatuan = s.idsatuan
            WHERE dp.idpengadaan = ?
        ";
        return DB::select($sql, [$idpengadaan]);
    }
}
