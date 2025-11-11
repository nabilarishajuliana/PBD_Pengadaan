<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VRole extends Model
{
    protected $table = 'v_role';
    public $timestamps = false;

    // Ambil semua role
    public static function getAllRole()
    {
        $sql = "SELECT idrole, nama_role FROM v_role";
        return DB::select($sql);
    }
}
