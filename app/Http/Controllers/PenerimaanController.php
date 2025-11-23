<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerimaan;
use App\Models\DetailPenerimaan;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    // List semua penerimaan
    public function index()
    {
        $penerimaan = Penerimaan::getAllPenerimaan();
        return view('superadmin.penerimaan.index', compact('penerimaan'));
    }

    // Tampilkan detail penerimaan
    public function show($id)
    {
        $header = Penerimaan::getPenerimaanById($id);
        
        if (!$header) {
            return redirect()->route('superadmin.penerimaan')
                ->with('error', 'Penerimaan tidak ditemukan.');
        }

        $items = DetailPenerimaan::getItemsByPenerimaanId($id);
        
        return view('superadmin.penerimaan.detail', compact('header', 'items'));
    }

    // ✨ FORM TAMBAH PENERIMAAN
    public function create()
    {
        $pengadaan_list = Penerimaan::getPengadaanBelumSelesai();
        
        return view('superadmin.penerimaan.create', compact('pengadaan_list'));
    }

    // ✨ AMBIL DETAIL BARANG DARI PENGADAAN (AJAX)
    public function getItemsByPengadaan($idpengadaan)
    {
        $items = DetailPenerimaan::getItemsForPenerimaan($idpengadaan);
        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    // ✨ PROSES SIMPAN PENERIMAAN
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idpengadaan' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.idbarang' => 'required|integer',
            'items.*.jumlah_terima' => 'required|integer|min:1',
            'items.*.harga_satuan_terima' => 'required|integer|min:1',
        ], [
            'idpengadaan.required' => 'Pengadaan harus dipilih',
            'items.required' => 'Minimal harus ada 1 barang yang diterima',
            'items.*.jumlah_terima.required' => 'Jumlah terima harus diisi',
            'items.*.jumlah_terima.min' => 'Jumlah terima minimal 1',
            'items.*.harga_satuan_terima.required' => 'Harga satuan harus diisi',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Insert header penerimaan
            $iduser = session('iduser'); // Ambil dari session login
            $idpengadaan = $request->idpengadaan;
            
            $idpenerimaan = Penerimaan::createPenerimaan($idpengadaan, $iduser);

            // 2. Insert detail penerimaan (trigger akan jalan otomatis)
            $hasItems = false;
            foreach ($request->items as $item) {
                if (isset($item['jumlah_terima']) && $item['jumlah_terima'] > 0) {
                    DetailPenerimaan::addItem(
                        $idpenerimaan,
                        $item['idbarang'],
                        $item['jumlah_terima'],
                        $item['harga_satuan_terima']
                    );
                    $hasItems = true;
                }
            }

            // Cek apakah ada item yang diinput
            if (!$hasItems) {
                throw new \Exception('Tidak ada barang yang diterima. Minimal 1 barang harus diinput.');
            }

            DB::commit();

            return redirect()->route('superadmin.penerimaan.show', $idpenerimaan)
                ->with('success', 'Penerimaan berhasil dibuat! Stok & harga barang otomatis terupdate.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal membuat penerimaan: ' . $e->getMessage())
                ->withInput();
        }
    }
}