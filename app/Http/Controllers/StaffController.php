<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Staff::paginate(20));
    }

    public function store(StoreStaffRequest $request)
    {
        return response()->json(Staff::create($request->validated()));

    }

    public function show(Staff $staff)
    {
        return response()->json($staff);
    }


    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->validated());

        return response()->json($staff);
    }


    public function destroy(Staff $staff)
    {
        $staff->delete();

        return response()->json(['message' => 'Staff deleted']);
    }
}
