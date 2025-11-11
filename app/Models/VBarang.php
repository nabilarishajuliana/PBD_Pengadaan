<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VBarang extends Model
{
 protected $table = 'v_barang';
    public $timestamps = false;

    // Barang aktif saja
    public static function getBarangAktif()
    {
        $sql = "SELECT idbarang, nama_barang, nama_satuan, harga, status 
                FROM v_barang 
                WHERE status = 1";
        return DB::select($sql);
    }

    // Semua barang (aktif dan nonaktif)
    public static function getBarangAll()
    {
        $sql = "SELECT idbarang, nama_barang, nama_satuan, harga, status 
                FROM v_barang_all";
        return DB::select($sql);
    }
}
