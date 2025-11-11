<?php

namespace App\Http\Controllers;

use App\Models\VRole;

class RoleController extends Controller
{
    public function index()
    {
        $role = VRole::getAllRole();
        return view('role.index', compact('role'));
    }
}
