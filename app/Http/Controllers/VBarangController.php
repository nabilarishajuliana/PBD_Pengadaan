<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VBarang;

class VBarangController extends Controller
{
    // Barang aktif
    public function index()
    {
        $barang = VBarang::getBarangAktif();
        $mode = 'aktif';
        return view('superadmin.barang.index', compact('barang', 'mode'));
    }

    // Semua barang
    public function all()
    {
        $barang = VBarang::getBarangAll();
        $mode = 'all';
        return view('superadmin.barang.index', compact('barang', 'mode'));
    }
}
