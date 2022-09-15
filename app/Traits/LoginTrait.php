<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\Approver;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

trait LoginTrait
{
    use HasApiTokens;


    public static function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(auth(self::$guardName)->attempt($validated)){

            $user = self::where('email', $request->email)->first();
            
            if(!$user->is_active){
                return response()->json(['message' => 'User is inactive. Please contact support'], 401);
            }

            $token = $user->createToken('access_token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['message' => 'Authentication failed'], 403);
    }

    public static function logout(){
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out']);
    }
}
