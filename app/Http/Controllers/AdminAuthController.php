<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        return Admin::login($request);
        
    }

    public function logout()
    {
        return Admin::logout();
    }
}
