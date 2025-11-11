<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerimaan;
use App\Models\DetailPenerimaan;

class PenerimaanController extends Controller
{
    // List semua penerimaan
    public function index()
    {
        $penerimaan = Penerimaan::getAllPenerimaan();
        return view('penerimaan.index', compact('penerimaan'));
    }

    // Tampilkan detail penerimaan
    public function show($id)
    {
        $header = Penerimaan::getPenerimaanById($id);
        if (!$header) {
            return redirect('/penerimaan')->with('error', 'Penerimaan tidak ditemukan.');
        }

        $items = DetailPenerimaan::getItemsByPenerimaanId($id);
        return view('penerimaan.detail', compact('header', 'items'));
    }
}
