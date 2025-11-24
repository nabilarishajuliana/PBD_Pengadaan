<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuStok;

class KartuStokController extends Controller
{
    // ✨ Tampilkan list semua kartu stok (dengan filter)
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $idbarang = $request->input('idbarang');
        $jenis_transaksi = $request->input('jenis_transaksi');
        $tanggal_dari = $request->input('tanggal_dari');
        $tanggal_sampai = $request->input('tanggal_sampai');

        // Ambil data kartu stok dengan filter
        $kartu_stok = KartuStok::getAllKartuStok(
            $idbarang,
            $jenis_transaksi,
            $tanggal_dari,
            $tanggal_sampai
        );

        // Ambil data barang untuk dropdown filter
        $barangs = KartuStok::getBarangForFilter();

        return view('superadmin.kartustok.index', compact(
            'kartu_stok',
            'barangs',
            'idbarang',
            'jenis_transaksi',
            'tanggal_dari',
            'tanggal_sampai'
        ));
    }

    // ✨ Tampilkan stok akhir per barang (rekap)
    public function rekap()
    {
        $stok_barang = KartuStok::getStokAkhirPerBarang();

        return view('superadmin.kartustok.rekap', compact('stok_barang'));
    }

    // ✨ Tampilkan detail kartu stok per barang
    public function detail($idbarang)
    {
        $barang = KartuStok::getBarangDetail($idbarang);

        if (!$barang) {
            return redirect()->route('superadmin.kartustok.rekap')
                ->with('error', 'Barang tidak ditemukan.');
        }

        $kartu_stok = KartuStok::getKartuStokByBarang($idbarang);

        return view('superadmin.kartustok.detail', compact('barang', 'kartu_stok'));
    }
}