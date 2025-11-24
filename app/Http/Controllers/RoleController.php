<?php

namespace App\Http\Controllers;

use App\Models\VRole;

class RoleController extends Controller
{
    public function index()
    {
        $role = VRole::getAllRole();
        return view('superadmin.role.index', compact('role'));
    }
}
