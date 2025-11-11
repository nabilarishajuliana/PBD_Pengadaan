<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    public $timestamps = false;

    // Ambil semua penjualan (ringkasan)
    public static function getAllPenjualan()
    {
        $sql = "
            SELECT
                pj.idpenjualan,
                pj.created_at,
                pj.subtotal_nilai,
                pj.ppn,
                pj.total_nilai,
                pj.iduser,
                u.username,
                pj.idmargin_penjualan,
                m.persen AS margin_persen
            FROM penjualan pj
            LEFT JOIN `user` u ON pj.iduser = u.iduser
            LEFT JOIN margin_penjualan m ON pj.idmargin_penjualan = m.idmargin_penjualan
            ORDER BY pj.created_at DESC
        ";
        return DB::select($sql);
    }

    // Ambil header penjualan by id
    public static function getPenjualanById($id)
    {
        $sql = "
            SELECT
                pj.idpenjualan,
                pj.created_at,
                pj.subtotal_nilai,
                pj.ppn,
                pj.total_nilai,
                pj.iduser,
                u.username,
                pj.idmargin_penjualan,
                m.persen AS margin_persen
            FROM penjualan pj
            LEFT JOIN `user` u ON pj.iduser = u.iduser
            LEFT JOIN margin_penjualan m ON pj.idmargin_penjualan = m.idmargin_penjualan
            WHERE pj.idpenjualan = ?
            LIMIT 1
        ";
        $res = DB::select($sql, [$id]);
        return count($res) ? $res[0] : null;
    }
}
