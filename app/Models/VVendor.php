<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VVendor extends Model
{
     protected $table = 'v_vendor';
    public $timestamps = false;

    // Data vendor aktif (status = 'A')
    public static function getVendorAktif()
    {
        $sql = "SELECT idvendor, nama_vendor, badan_hukum, status FROM v_vendor WHERE status = 'A'";
        return DB::select($sql);
    }

    // Semua vendor (aktif & nonaktif)
    public static function getVendorAll()
    {
        $sql = "SELECT idvendor, nama_vendor, badan_hukum, status FROM v_vendor_all";
        return DB::select($sql);
    }

    public static function getVendorById($id)
{
    $sql = "SELECT * FROM vendor WHERE idvendor = ?";
    $result = DB::select($sql, [$id]);

    return $result ? $result[0] : null;
}

public static function updateStatus($id, $status)
{
    $sql = "UPDATE vendor SET status = ? WHERE idvendor = ?";
    return DB::update($sql, [$status, $id]);
}

public static function insertVendor($nama_vendor, $badan_hukum)
{
    $sql = "INSERT INTO vendor (nama_vendor, badan_hukum, status)
            VALUES (?, ?, 'A')";  // status langsung aktif
    return DB::insert($sql, [$nama_vendor, $badan_hukum]);
}


}
