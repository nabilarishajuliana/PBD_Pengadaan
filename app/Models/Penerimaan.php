<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penerimaan extends Model
{
    protected $table = 'penerimaan';
    public $timestamps = false;

    // Ambil semua penerimaan (ringkasan)
    public static function getAllPenerimaan()
    {
        $sql = "
            SELECT 
                p.idpenerimaan,
                p.created_at,
                p.status,
                p.idpengadaan,
                p.iduser,
                u.username,
                pg.idpengadaan AS pengadaan_id,
                pg.timestamp AS pengadaan_timestamp,
                v.idvendor,
                v.nama_vendor
            FROM penerimaan p
            LEFT JOIN pengadaan pg ON p.idpengadaan = pg.idpengadaan
            LEFT JOIN vendor v ON pg.vendor_idvendor = v.idvendor
            LEFT JOIN `user` u ON p.iduser = u.iduser
            ORDER BY p.created_at DESC
        ";
        return DB::select($sql);
    }

    // Ambil header penerimaan berdasarkan id
    public static function getPenerimaanById($id)
    {
        $sql = "
            SELECT 
                p.idpenerimaan,
                p.created_at,
                p.status,
                p.idpengadaan,
                p.iduser,
                u.username,
                pg.idpengadaan AS pengadaan_id,
                pg.timestamp AS pengadaan_timestamp,
                v.idvendor,
                v.nama_vendor
            FROM penerimaan p
            LEFT JOIN pengadaan pg ON p.idpengadaan = pg.idpengadaan
            LEFT JOIN vendor v ON pg.vendor_idvendor = v.idvendor
            LEFT JOIN `user` u ON p.iduser = u.iduser
            WHERE p.idpenerimaan = ?
            LIMIT 1
        ";
        $res = DB::select($sql, [$id]);
        return count($res) ? $res[0] : null;
    }
}
