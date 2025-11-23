<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('iduser')) {
            return redirect()->route('login');
        }

        $role = session('role');

        if ($role === 'superAdmin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('login')->with('error', 'Role tidak valid.');
    }

    public function superAdmin()
    {
        return view('superadmin.dashboard', [
            'username' => session('username'),
            'role' => session('role')
        ]);
    }

    public function admin()
    {
        return view('admin.dashboard', [
            'username' => session('username'),
            'role' => session('role')
        ]);
    }
}
