<?php

namespace App\Http\Controllers;

use App\Models\Retur;
use App\Models\DetailRetur;

class ReturController extends Controller
{
    // Tampilkan semua retur
    public function index()
    {
        $retur = Retur::getAllRetur();
        return view('superadmin.retur.index', compact('retur'));
    }

    // Tampilkan detail retur berdasarkan id
    public function show($id)
    {
        $detail = DetailRetur::getByReturId($id);
        $header = Retur::getById($id);
        return view('superadmin.retur.detail', compact('detail', 'header', 'id'));
    }
}
