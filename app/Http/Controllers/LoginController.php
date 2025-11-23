<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function showLogin()
    {
        // if (!session()->has('iduser')) {
        //     return redirect()->route('login');
        // }

        // $role = session('role');

        // if ($role === 'superAdmin') {
        //     return redirect()->route('superadmin.dashboard');
        // } elseif ($role === 'admin') {
        //     return redirect()->route('admin.dashboard');
        // }
        
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // ambil user (raw SQL melalui User)
        $userRow = User::findByUsername($username);

        if (!$userRow) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        // DB punya password plain (sesuaikan dengan DB mu).
        // Jika DB hashed, gunakan Hash::check; di sini kita pakai direct compare:
        if ($userRow['password'] !== $password) {
            return back()->with('error', 'Password salah.');
        }

        // ambil role name
        $roleName = User::getRoleName((int)$userRow['idrole']);

        // simpan session
        session([
            'iduser' => $userRow['iduser'],
            'username' => $userRow['username'],
            'role' => $roleName
        ]);

        // optional: update last login
        // User::updateLastLogin((int)$userRow['iduser']);

        // redirect sesuai role
        if ($roleName === 'superAdmin') {
            return redirect('/superadmin/dashboard');
        }

        return redirect('/admin/dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}
