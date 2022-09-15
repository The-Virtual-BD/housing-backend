<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use App\Http\Requests\StoreApproverRequest;
use App\Http\Requests\UpdateApproverRequest;
use Illuminate\Http\JsonResponse;

class ApproverController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Approver::paginate(20));
    }

    public function store(StoreApproverRequest $request)
    {
        return response()->json(Approver::create($request->validated()));

    }

    public function show(Approver $approver)
    {
        return response()->json($approver);
    }


    public function update(UpdateApproverRequest $request, Approver $approver)
    {
        $approver->update($request->validated());

        return response()->json($approver);
    }


    public function destroy(Approver $approver)
    {
        $approver->delete();

        return response()->json(['message' => 'Approver deleted']);
    }
}
