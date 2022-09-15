<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = new User();

        if($request->search_by && $request->search_query){
            $users = $users->where($request->search_by, 'like', '%'.$request->search_query.'%');
        }

        return response()->json($users->paginate(20));
    }

    public function store(StoreUserRequest $request)
    {
        return response()->json(User::create($request->validated()));
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->applications()->delete();

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

}
