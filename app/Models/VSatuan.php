<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VSatuan extends Model
{
    protected $table = 'v_satuan';
    public $timestamps = false;

    // Satuan aktif (status = 1)
    public static function getSatuanAktif()
    {
        $sql = "SELECT idsatuan, nama_satuan, status FROM v_satuan WHERE status = 1";
        return DB::select($sql);
    }

    // Semua satuan (aktif & nonaktif)
    public static function getSatuanAll()
    {
        $sql = "SELECT idsatuan, nama_satuan, status FROM v_satuan_all";
        return DB::select($sql);
    }
}
