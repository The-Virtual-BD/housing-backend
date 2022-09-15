<?php

namespace App\Http\Controllers;

use App\Models\HousingModel;
use App\Models\Subdivision;
use App\Http\Requests\StoreSubdivisionRequest;
use App\Http\Requests\UpdateSubdivisionRequest;
use Illuminate\Http\Request;

class SubdivisionController extends Controller
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
            'category' => 'nullable|string',
            'include_in_application' => 'nullable|boolean'
        ]);

        $subdivisions = new Subdivision();

        if($request->has('location') && $request->location){
            $subdivisions = $subdivisions->where('location', $request->location);
        }

        if($request->has('category')  && $request->category){
            $subdivisions = $subdivisions->where('category', $request->category);
        }

        return response()->json($subdivisions->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubdivisionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubdivisionRequest $request)
    {
        $validated = $request->validated();

        $subdivision = Subdivision::create($validated);

        if($request->has('gallery')){
            foreach ($request->file('gallery') as $photo){
                $subdivision->addMedia($photo)->toMediaCollection('gallery');
            }
        }

        return response()->json($subdivision);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function show(Subdivision $subdivision)
    {
        return response()->json($subdivision);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubdivisionRequest  $request
     * @param  \App\Models\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubdivisionRequest $request, Subdivision $subdivision)
    {
        $subdivision->update($request->validated());

        if($request->has('gallery')){
            $subdivision->clearMediaCollection('gallery');

            foreach ($request->file('gallery') as $photo){
                $subdivision->addMedia($photo)->toMediaCollection('gallery');
            }
        }

        return response()->json($subdivision);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subdivision  $subdivision
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subdivision $subdivision)
    {
        $subdivision->delete();

        return response()->json(['message' => 'Subdivision deleted.']);
    }

    public function getLocations(){
        $locations = Subdivision::select('location')->distinct()->get()->pluck('location');

        return response()->json($locations);
    }

    public function forApplication(){
        $subdivisions = Subdivision::where('include_in_application', true)->get();

        return response()->json($subdivisions);
    }
}
