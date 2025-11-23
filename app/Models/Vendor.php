<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendor extends Model
{
    protected $table = 'vendor';
    protected $primaryKey = 'idvendor';
    public $timestamps = false;

    // Ambil vendor yang aktif
    public static function getActiveVendors()
    {
        $sql = "SELECT idvendor, nama_vendor FROM vendor WHERE status = 'A' ORDER BY nama_vendor ASC";
        return DB::select($sql);
    }
}