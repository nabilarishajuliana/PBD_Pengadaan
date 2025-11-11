<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\DetailPengadaan;

class PengadaanController extends Controller
{
    // List semua pengadaan
    public function index()
    {
        $pengadaan = Pengadaan::getAllPengadaan();
        return view('pengadaan.index', compact('pengadaan'));
    }

    // Tampilkan detail pengadaan (items)
    public function show($id)
    {
        $header = Pengadaan::getPengadaanById($id);
        if (!$header) {
            return redirect('/pengadaan')->with('error', 'Pengadaan tidak ditemukan.');
        }

        $items = DetailPengadaan::getItemsByPengadaanId($id);
        return view('pengadaan.detail', compact('header', 'items'));
    }
}
