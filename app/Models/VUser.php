<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VUser extends Model
{
    protected $table = 'v_user';
    public $timestamps = false;

    // Ambil semua user beserta role-nya
    public static function getAllUser()
    {
        $sql = "SELECT iduser, username, nama_role FROM v_user";
        return DB::select($sql);
    }

    public static function insertUser($username, $password, $idrole)
{
    $sql = "INSERT INTO user (username, password, idrole) VALUES (?, ?, ?)";
    return DB::insert($sql, [$username, $password, $idrole]);
}

}
