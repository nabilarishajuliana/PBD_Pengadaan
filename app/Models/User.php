<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

     // ambil user by username
    public static function findByUsername(string $username)
    {
        $rows = DB::select('SELECT * FROM `user` WHERE username = ? LIMIT 1', [$username]);
        return count($rows) ? (array) $rows[0] : null;
    }

    // ambil role name by idrole
    public static function getRoleName(int $idrole)
    {
        $rows = DB::select('SELECT nama_role FROM `role` WHERE idrole = ? LIMIT 1', [$idrole]);
        return count($rows) ? $rows[0]->nama_role : null;
    }

    // example: create session log / last login update (optional)
    public static function updateLastLogin(int $iduser)
    {
        DB::statement('UPDATE `user` SET last_login = NOW() WHERE iduser = ?', [$iduser]);
    }
}
