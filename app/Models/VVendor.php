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
}
