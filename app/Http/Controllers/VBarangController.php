<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VBarang;
use Illuminate\Support\Facades\DB;

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

    public function create()
    {
        // ambil daftar satuan untuk dropdown
        $satuan = DB::select("SELECT idsatuan, nama_satuan FROM satuan WHERE status = 1");
        return view('superadmin.barang.create', compact('satuan'));
    }

    public function store(Request $req)
    {
        // VALIDASI
        $req->validate([
            'nama' => 'required|string|max:100',
            'jenis' => 'required|in:B,J',
            'idsatuan' => 'required|integer',
            'status' => 'required|in:0,1',
            'harga' => 'required|integer|min:0',
        ], [
            'nama.required' => 'Nama barang wajib diisi.',
            'harga.required' => 'Harga awal wajib diisi.',
        ]);

        // SIMPAN KE DB
        VBarang::insertBarang(
            $req->nama,
            $req->jenis,
            $req->idsatuan,
            $req->status,
            $req->harga
        );

        return redirect()->route('superadmin.barang')
            ->with('success', 'Barang baru berhasil ditambahkan!');
    }

    public function toggleStatus($id)
{
    // 1. Ambil data barang
    $barang = VBarang::getBarangById($id);

    if (!$barang) {
        return back()->with('error', 'Barang tidak ditemukan.');
    }

    // 2. Tentukan status baru
    $newStatus = $barang->status == 1 ? 0 : 1;

    // 3. Update status
    VBarang::updateStatus($id, $newStatus);

    // 4. Redirect balik
    return back()->with('success', 'Status barang berhasil diperbarui.');
}

}
