<?php

namespace App\Http\Controllers;

use App\Models\HousingModel;
use App\Http\Requests\StoreHousingModelRequest;
use App\Http\Requests\UpdateHousingModelRequest;
use Illuminate\Http\Request;

class HousingModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'location' => 'nullable|string',
            'bedrooms' => 'nullable|string',
            'bathrooms' => 'nullable|string',
        ]);

        $housingModels = new HousingModel();

        if ($request->has('location') && $request->location) {
            $housingModels = $housingModels->where('location', $request->location);
        }

        if ($request->has('bedrooms') && $request->bedrooms) {
            $housingModels = $housingModels->where('bedrooms', $request->bedrooms);
        }

        if ($request->has('bathrooms') && $request->bathrooms) {
            $housingModels = $housingModels->where('bathrooms', $request->bathrooms);
        }

        return response()->json($housingModels->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreHousingModelRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHousingModelRequest $request)
    {
        $gallery = $request->file('gallery');
        $master_plan = $request->file('master_plan');
        $basic_plan = $request->file('basic_plan');

        $validated = $request->validated();
        $housingModel = HousingModel::create($validated);


        foreach ($gallery as $photo) {
            $housingModel->addMedia($photo)->toMediaCollection('gallery');
        }

        $housingModel->addMedia($master_plan)->toMediaCollection('master_plan');

        $housingModel->addMedia($basic_plan)->toMediaCollection('basic_plan');


        return response()->json($housingModel);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\HousingModel $housingModel
     * @return \Illuminate\Http\Response
     */
    public function show(HousingModel $housingModel)
    {
        return response()->json($housingModel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateHousingModelRequest $request
     * @param \App\Models\HousingModel $housingModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHousingModelRequest $request, HousingModel $housingModel)
    {
        $gallery = $request->file('gallery');
        $master_plan = $request->file('master_plan');
        $basic_plan = $request->file('basic_plan');

        $validated = $request->validated();
        $housingModel->update($validated);

        if ($gallery && count($gallery)) {
            $housingModel->clearMediaCollection('gallery');

            foreach ($gallery as $photo) {
                $housingModel->addMedia($photo)->toMediaCollection('gallery');
            }
        }

        if ($master_plan) {
            $housingModel->clearMediaCollection('master_plan');
            $housingModel->addMedia($master_plan)->toMediaCollection('master_plan');
        }

        if ($basic_plan) {
            $housingModel->clearMediaCollection('basic_plan');
            $housingModel->addMedia($basic_plan)->toMediaCollection('basic_plan');
        }

        return response()->json($housingModel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\HousingModel $housingModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(HousingModel $housingModel)
    {
        $housingModel->delete();

        return response()->json(['message' => 'Housing model deleted.']);
    }

    public function getQueries()
    {
        $locations = HousingModel::select('location')->distinct()->get()->pluck('location');
        $bedrooms = HousingModel::select('bedrooms')->distinct()->get()->pluck('bedrooms');
        $bathrooms = HousingModel::select('bathrooms')->distinct()->get()->pluck('bathrooms');

        $queries = ['locations' => $locations, 'bathrooms' => $bathrooms, 'bedrooms' => $bedrooms];

        return response()->json($queries);
    }

    public function forApplication()
    {
        $housingModels = HousingModel::where('include_in_application', true)->get();

        return response()->json($housingModels);
    }
}
