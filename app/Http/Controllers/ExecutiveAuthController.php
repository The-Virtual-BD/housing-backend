<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use Illuminate\Http\Request;

class ExecutiveAuthController extends Controller
{
    public function login(Request $request)
    {
        return Executive::login($request);
        // return response()->json(['status'=>200, 'message'=>'Im in exicutive auth controller']);
    }

    public function logout()
    {
        return Executive::logout();
    }
}
