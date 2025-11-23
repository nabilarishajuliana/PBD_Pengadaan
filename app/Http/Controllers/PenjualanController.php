<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // List semua penjualan
    public function index()
    {
        $penjualan = Penjualan::getAllPenjualan();
        return view('superadmin.penjualan.index', compact('penjualan'));
    }

    // Tampilkan detail penjualan
    public function show($id)
    {
        $header = Penjualan::getPenjualanById($id);
        
        if (!$header) {
            return redirect()->route('superadmin.penjualan')
                ->with('error', 'Penjualan tidak ditemukan.');
        }

        $items = DetailPenjualan::getItemsByPenjualanId($id);
        
        return view('superadmin.penjualan.detail', compact('header', 'items'));
    }

    // ✨ FORM TAMBAH PENJUALAN
    public function create()
    {
        $margins = Penjualan::getAllMargin();
        $activeMargin = Penjualan::getActiveMargin();
        $barangs = Barang::getActiveBarangForPenjualan();
        
        return view('superadmin.penjualan.create', compact('margins', 'activeMargin', 'barangs'));
    }

    // ✨ HITUNG HARGA JUAL BERDASARKAN MARGIN (AJAX)
    public function calculatePrice(Request $request)
    {
        $idbarang = $request->idbarang;
        $marginPersen = $request->margin_persen;

        // Ambil harga beli barang
        $barang = Barang::getBarangById($idbarang);
        
        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        $hargaBeli = $barang->harga;
        $hargaJual = round($hargaBeli + ($hargaBeli * $marginPersen / 100));

        return response()->json([
            'success' => true,
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaJual,
            'margin_rupiah' => ($hargaJual - $hargaBeli)
        ]);
    }

    // ✨ PROSES SIMPAN PENJUALAN
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idmargin_penjualan' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.idbarang' => 'required|integer',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:1',
        ], [
            'idmargin_penjualan.required' => 'Margin penjualan harus dipilih',
            'items.required' => 'Minimal harus ada 1 barang',
            'items.*.idbarang.required' => 'Barang harus dipilih',
            'items.*.jumlah.required' => 'Jumlah harus diisi',
            'items.*.jumlah.min' => 'Jumlah minimal 1',
            'items.*.harga_satuan.required' => 'Harga satuan harus diisi',
            'items.*.harga_satuan.min' => 'Harga satuan minimal 1',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Insert header penjualan
            $iduser = session('iduser'); // Ambil dari session login
            $idmargin = $request->idmargin_penjualan;
            
            $idpenjualan = Penjualan::createPenjualan($iduser, $idmargin);

            // 2. Insert detail penjualan (trigger akan jalan otomatis untuk update stok & total)
            foreach ($request->items as $item) {
                DetailPenjualan::addItem(
                    $idpenjualan,
                    $item['idbarang'],
                    $item['jumlah'],
                    $item['harga_satuan']
                );
            }

            DB::commit();

            return redirect()->route('superadmin.penjualan.show', $idpenjualan)
                ->with('success', 'Penjualan berhasil dibuat! Stok otomatis terupdate.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal membuat penjualan: ' . $e->getMessage())
                ->withInput();
        }
    }
}