<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VUser;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Halaman Index User
    public function index()
    {
        $user = VUser::getAllUser();
        return view('superadmin.user.index', compact('user'));
    }

    // Halaman Create User
    public function create()
    {
        // Ambil role dari tabel role
        $roles = DB::select("SELECT idrole, nama_role FROM role");
        return view('superadmin.user.create', compact('roles'));
    }

    // Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:50|unique:user,username',
            'password' => 'required|min:3|max:50',
            'idrole'   => 'required|integer',
        ]);

        // Insert ke database (TANPA ENKRIPSI)
        VUser::insertUser(
            $request->username,
            $request->password,
            $request->idrole
        );

        return redirect()->route('superadmin.user')
                         ->with('success', 'User baru berhasil dibuat!');
    }
}
