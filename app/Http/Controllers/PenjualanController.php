<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class PenjualanController extends Controller
{
    // List semua penjualan
    public function index()
    {
        $penjualan = Penjualan::getAllPenjualan();
        return view('penjualan.index', compact('penjualan'));
    }

    // Detail satu penjualan
    public function show($id)
    {
        $header = Penjualan::getPenjualanById($id);
        if (!$header) {
            return redirect('/penjualan')->with('error', 'Transaksi penjualan tidak ditemukan.');
        }

        $items = DetailPenjualan::getItemsByPenjualanId($id);
        return view('penjualan.detail', compact('header', 'items'));
    }
}
