<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pengadaan extends Model
{
    protected $table = 'pengadaan';
    protected $primaryKey = 'idpengadaan';
    public $timestamps = false;

    // Ambil semua pengadaan (ringkasan)
    public static function getAllPengadaan()
    {
        $sql = "
            SELECT 
                p.idpengadaan,
                p.timestamp,
                p.status,
                p.subtotal_nilai,
                p.ppn,
                p.total_nilai,
                v.idvendor,
                v.nama_vendor,
                u.iduser,
                u.username
            FROM pengadaan p
            JOIN vendor v ON p.vendor_idvendor = v.idvendor
            JOIN user u ON p.user_iduser = u.iduser
            ORDER BY p.timestamp DESC
        ";
        return DB::select($sql);
    }

    // Ambil satu pengadaan (header)
    public static function getPengadaanById($id)
    {
        $sql = "
            SELECT 
                p.idpengadaan,
                p.timestamp,
                p.status,
                p.subtotal_nilai,
                p.ppn,
                p.total_nilai,
                v.idvendor,
                v.nama_vendor,
                u.iduser,
                u.username
            FROM pengadaan p
            JOIN vendor v ON p.vendor_idvendor = v.idvendor
            JOIN user u ON p.user_iduser = u.iduser
            WHERE p.idpengadaan = ?
            LIMIT 1
        ";
        $res = DB::select($sql, [$id]);
        return count($res) ? $res[0] : null;
    }

       // ✨ CREATE PENGADAAN BARU
    public static function createPengadaan($iduser, $idvendor)
    {
        $sql = "
            INSERT INTO pengadaan (user_iduser, vendor_idvendor, status, timestamp)
            VALUES (?, ?, 'N', NOW())
        ";
        DB::insert($sql, [$iduser, $idvendor]);
        return DB::getPdo()->lastInsertId();
    }
}