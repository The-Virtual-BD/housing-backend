<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffAuthController extends Controller
{
    public function login(Request $request)
    {
        return Staff::login($request);
    }

    public function logout()
    {
        return Staff::logout();
    }
}
