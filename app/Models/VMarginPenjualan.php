<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VMarginPenjualan extends Model
{
    protected $table = 'v_margin_penjualan';
    public $timestamps = false;

    // Margin aktif saja
    public static function getMarginAktif()
    {
        $sql = "SELECT idmargin_penjualan, persen, status, dibuat_oleh, created_at, updated_at
                FROM v_margin_penjualan
                WHERE status = 1";
        return DB::select($sql);
    }

    // Semua margin (aktif & nonaktif)
    public static function getMarginAll()
    {
        $sql = "SELECT idmargin_penjualan, persen, status, dibuat_oleh, created_at, updated_at
                FROM v_margin_penjualan_all";
        return DB::select($sql);
    }
}
