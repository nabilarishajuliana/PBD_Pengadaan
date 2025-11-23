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
        return view('vendor.index', compact('vendor', 'mode'));
    }

    // Semua vendor
    public function all()
    {
        $vendor = VVendor::getVendorAll();
        $mode = 'all';
        return view('vendor.index', compact('vendor', 'mode'));
    }

    
}
