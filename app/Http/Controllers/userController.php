<?php

namespace App\Http\Controllers;

use App\Models\VUser;

class UserController extends Controller
{
    public function index()
    {
        $user = VUser::getAllUser();
        return view('superadmin.user.index', compact('user'));
    }
}
