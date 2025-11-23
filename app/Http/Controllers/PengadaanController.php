<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\DetailPengadaan;
use App\Models\Vendor;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaan = Pengadaan::getAllPengadaan();
        return view('superadmin.pengadaan.index', compact('pengadaan'));
    }

    public function show($id)
    {
        $header = Pengadaan::getPengadaanById($id);

        if (!$header) {
            return redirect()->route('superadmin.pengadaan')
                ->with('error', 'Pengadaan tidak ditemukan.');
        }

        $items = DetailPengadaan::getItemsByPengadaanId($id);

        return view('superadmin.pengadaan.detail', compact('header', 'items'));
    }

    // ✨ FORM TAMBAH PENGADAAN
    public function create()
    {
        $vendors = Vendor::getActiveVendors();
        $barangs = Barang::getActiveBarangForPengadaan();
        
        return view('superadmin.pengadaan.create', compact('vendors', 'barangs'));
    }

    // ✨ PROSES SIMPAN PENGADAAN
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idvendor' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.idbarang' => 'required|integer',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|integer|min:1',
        ], [
            'idvendor.required' => 'Vendor harus dipilih',
            'items.required' => 'Minimal harus ada 1 barang',
            'items.*.idbarang.required' => 'Barang harus dipilih',
            'items.*.jumlah.required' => 'Jumlah harus diisi',
            'items.*.jumlah.min' => 'Jumlah minimal 1',
            'items.*.harga_satuan.required' => 'Harga satuan harus diisi',
            'items.*.harga_satuan.min' => 'Harga satuan minimal 1',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Insert header pengadaan
            $iduser = session('iduser'); // Ambil dari session login
            $idvendor = $request->idvendor;
            
            $idpengadaan = Pengadaan::createPengadaan($iduser, $idvendor);

            // 2. Insert detail pengadaan
            foreach ($request->items as $item) {
                DetailPengadaan::addItem(
                    $idpengadaan,
                    $item['idbarang'],
                    $item['jumlah'],
                    $item['harga_satuan']
                );
            }

            DB::commit();

            return redirect()->route('superadmin.pengadaan.show', $idpengadaan)
                ->with('success', 'Pengadaan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal membuat pengadaan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
