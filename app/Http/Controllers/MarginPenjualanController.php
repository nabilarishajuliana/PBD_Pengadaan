<?php

namespace App\Http\Controllers;

use App\Models\VMarginPenjualan;

class MarginPenjualanController extends Controller
{
    // Menampilkan margin aktif
    public function index()
    {
        $margin = VMarginPenjualan::getMarginAktif();
        $mode = 'aktif';
        return view('superadmin.margin.index', compact('margin', 'mode'));
    }

    // Menampilkan semua margin
    public function all()
    {
        $margin = VMarginPenjualan::getMarginAll();
        $mode = 'all';
        return view('superadmin.margin.index', compact('margin', 'mode'));
    }
}
