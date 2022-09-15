<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use Illuminate\Http\Request;

class ApproverAuthController extends Controller
{
    public function login(Request $request){
       return Approver::login($request);
    }

    public function logout(){
        return Approver::logout();
    }
}
