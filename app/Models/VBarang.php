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
        $sql = "SELECT idbarang, nama_barang, nama_satuan, harga,jenis, status 
                FROM v_barang 
                WHERE status = 1";
        return DB::select($sql);
    }

    // Semua barang (aktif dan nonaktif)
    public static function getBarangAll()
    {
        $sql = "SELECT idbarang, nama_barang, nama_satuan, harga,jenis, status 
                FROM v_barang_all";
        return DB::select($sql);
    }

    public static function insertBarang($nama, $jenis, $idsatuan, $status, $harga)
    {
        $sql = "INSERT INTO barang (nama, jenis, idsatuan, status, harga)
            VALUES (?, ?, ?, ?, ?)";

        return DB::insert($sql, [$nama, $jenis, $idsatuan, $status, $harga]);
    }

    public static function getBarangById($id)
{
    $sql = "SELECT * FROM barang WHERE idbarang = ?";
    $result = DB::select($sql, [$id]);

    return $result ? $result[0] : null;
}

public static function updateStatus($id, $status)
{
    $sql = "UPDATE barang SET status = ? WHERE idbarang = ?";
    return DB::update($sql, [$status, $id]);
}

}
