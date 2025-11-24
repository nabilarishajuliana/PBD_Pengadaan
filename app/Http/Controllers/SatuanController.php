<?php

namespace App\Http\Controllers;

use App\Models\VSatuan;

class SatuanController extends Controller
{
    // Menampilkan satuan aktif
    public function index()
    {
        $satuan = VSatuan::getSatuanAktif();
        $mode = 'aktif';
        return view('superadmin.satuan.index', compact('satuan', 'mode'));
    }

    // Menampilkan semua satuan
    public function all()
    {
        $satuan = VSatuan::getSatuanAll();
        $mode = 'all';
        return view('superadmin.satuan.index', compact('satuan', 'mode'));
    }
}
