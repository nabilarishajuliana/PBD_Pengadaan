<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'idpenjualan';
    public $timestamps = false;

    // Ambil semua penjualan (ringkasan)
    public static function getAllPenjualan()
    {
        $sql = "
            SELECT 
                p.idpenjualan,
                p.created_at,
                p.subtotal_nilai,
                p.ppn,
                p.total_nilai,
                u.iduser,
                u.username,
                m.idmargin_penjualan,
                m.persen AS margin_persen
            FROM penjualan p
            JOIN user u ON p.iduser = u.iduser
            JOIN margin_penjualan m ON p.idmargin_penjualan = m.idmargin_penjualan
            ORDER BY p.created_at DESC
        ";
        return DB::select($sql);
    }

    // Ambil satu penjualan (header)
    public static function getPenjualanById($id)
    {
        $sql = "
            SELECT 
                p.idpenjualan,
                p.created_at,
                p.subtotal_nilai,
                p.ppn,
                p.total_nilai,
                u.iduser,
                u.username,
                m.idmargin_penjualan,
                m.persen AS margin_persen
            FROM penjualan p
            JOIN user u ON p.iduser = u.iduser
            JOIN margin_penjualan m ON p.idmargin_penjualan = m.idmargin_penjualan
            WHERE p.idpenjualan = ?
            LIMIT 1
        ";
        $res = DB::select($sql, [$id]);
        return count($res) ? $res[0] : null;
    }

    // ✨ Ambil margin penjualan yang aktif
    public static function getActiveMargin()
    {
        $sql = "
            SELECT 
                idmargin_penjualan,
                persen,
                status
            FROM margin_penjualan
            WHERE status = 1
            ORDER BY idmargin_penjualan DESC
            LIMIT 1
        ";
        $res = DB::select($sql);
        return count($res) ? $res[0] : null;
    }

    // ✨ Ambil semua margin untuk dropdown
    public static function getAllMargin()
    {
        $sql = "
            SELECT 
                idmargin_penjualan,
                persen,
                status
            FROM margin_penjualan
            ORDER BY persen ASC
        ";
        return DB::select($sql);
    }

    // ✨ CREATE PENJUALAN BARU
    public static function createPenjualan($iduser, $idmargin)
    {
        $sql = "
            INSERT INTO penjualan (iduser, idmargin_penjualan, created_at, subtotal_nilai, ppn, total_nilai)
            VALUES (?, ?, NOW(), 0, 0, 0)
        ";
        DB::insert($sql, [$iduser, $idmargin]);
        return DB::getPdo()->lastInsertId();
    }
}