<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Retur extends Model
{
    protected $table = 'retur';
    public $timestamps = false;

    // Ambil semua retur (header)
    public static function getAllRetur()
    {
        $sql = "SELECT r.idretur, r.idpenerimaan, r.iduser, r.created_at, 
                       u.username AS nama_user
                FROM retur r
                JOIN user u ON r.iduser = u.iduser
                ORDER BY r.idretur DESC";
        return DB::select($sql);
    }

    // Ambil satu retur berdasarkan id
    public static function getById($idretur)
    {
        $sql = "SELECT r.idretur, r.idpenerimaan, r.iduser, r.created_at, 
                       u.username AS nama_user
                FROM retur r
                JOIN user u ON r.iduser = u.iduser
                WHERE r.idretur = ?
                LIMIT 1";
        return DB::select($sql, [$idretur]);
    }
}
