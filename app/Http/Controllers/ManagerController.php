<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;

class ManagerController extends Controller
{
    public function index()
    {
        return response()->json(Manager::paginate(20));
    }

    public function store(StoreManagerRequest $request)
    {
        return response()->json(Manager::create($request->validated()));
    }

    public function show(Manager $manager)
    {
        return response()->json($manager);
    }

    public function update(UpdateManagerRequest $request, Manager $manager)
    {
        $manager->update($request->validated());

        return response()->json($manager);
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();

        return response()->json(['message' => 'Manager deleted']);
    }
}
