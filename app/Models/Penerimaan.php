<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penerimaan extends Model
{
    protected $table = 'penerimaan';
    protected $primaryKey = 'idpenerimaan';
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
                pg.timestamp AS pengadaan_timestamp,
                v.nama_vendor
            FROM penerimaan p
            JOIN pengadaan pg ON p.idpengadaan = pg.idpengadaan
            JOIN vendor v ON pg.vendor_idvendor = v.idvendor
            JOIN user u ON p.iduser = u.iduser
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
                pg.timestamp AS pengadaan_timestamp,
                pg.status AS pengadaan_status,
                v.nama_vendor
            FROM penerimaan p
            JOIN pengadaan pg ON p.idpengadaan = pg.idpengadaan
            JOIN vendor v ON pg.vendor_idvendor = v.idvendor
            JOIN user u ON p.iduser = u.iduser
            WHERE p.idpenerimaan = ?
            LIMIT 1
        ";
        $res = DB::select($sql, [$id]);
        return count($res) ? $res[0] : null;
    }

    // ✨ CREATE PENERIMAAN BARU
    public static function createPenerimaan($idpengadaan, $iduser)
    {
        $sql = "
            INSERT INTO penerimaan (idpengadaan, iduser, created_at, status)
            VALUES (?, ?, NOW(), 'F')
        ";
        DB::insert($sql, [$idpengadaan, $iduser]);
        return DB::getPdo()->lastInsertId();
    }

    // ✨ Ambil pengadaan yang belum selesai (status 'N')
    public static function getPengadaanBelumSelesai()
    {
        $sql = "
            SELECT 
                p.idpengadaan,
                p.timestamp,
                v.nama_vendor,
                p.subtotal_nilai,
                p.ppn,
                p.total_nilai
            FROM pengadaan p
            JOIN vendor v ON p.vendor_idvendor = v.idvendor
            WHERE p.status = 'N'
            ORDER BY p.timestamp DESC
        ";
        return DB::select($sql);
    }
}