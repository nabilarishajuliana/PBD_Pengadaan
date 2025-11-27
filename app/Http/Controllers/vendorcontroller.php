<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VVendor;

class vendorcontroller extends Controller
{
    // Vendor aktif saja
    public function index()
    {
        $vendor = VVendor::getVendorAktif();
        $mode = 'aktif';
        return view('superadmin.vendor.index', compact('vendor', 'mode'));
    }

    // Semua vendor
    public function all()
    {
        $vendor = VVendor::getVendorAll();
        $mode = 'all';
        return view('superadmin.vendor.index', compact('vendor', 'mode'));
    }

    public function toggleStatus($id)
    {
        // 1. Ambil data vendor dari tabel asli via model
        $vendor = VVendor::getVendorById($id);

        if (!$vendor) {
            return back()->with('error', 'Vendor tidak ditemukan.');
        }

        // 2. Flip status: A => N, N => A
        $newStatus = $vendor->status === 'A' ? 'N' : 'A';

        // 3. Update status
        VVendor::updateStatus($id, $newStatus);

        // 4. Redirect balik
        return back()->with('success', 'Status vendor berhasil diperbarui.');
    }

    // FORM CREATE
    public function create()
    {
        return view('superadmin.vendor.create');
    }

    // SIMPAN VENDOR BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|min:3|max:100',
            'badan_hukum' => 'required',
        ]);

        // Insert vendor baru
        VVendor::insertVendor(
            $request->nama_vendor,
            $request->badan_hukum
        );

        return redirect()->route('superadmin.vendor')
            ->with('success', 'Vendor berhasil ditambahkan!');
    }
}
