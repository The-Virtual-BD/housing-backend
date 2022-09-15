<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use App\Http\Requests\StoreExecutiveRequest;
use App\Http\Requests\UpdateExecutiveRequest;
use Illuminate\Http\JsonResponse;

class ExecutiveController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Executive::paginate(20));
    }

    public function store(StoreExecutiveRequest $request)
    {
        return response()->json(Executive::create($request->validated()));

    }

    public function show(Executive $executive)
    {
        return response()->json($executive);
    }


    public function update(UpdateExecutiveRequest $request, Executive $executive)
    {
        $executive->update($request->validated());

        return response()->json($executive);
    }


    public function destroy(Executive $executive)
    {
        $executive->delete();

        return response()->json(['message' => 'Executive deleted']);
    }
}
