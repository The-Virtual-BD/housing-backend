<?php

namespace App\Http\Controllers;

use App\Mail\Users\ApplicationSubmitted;
use App\Mail\Users\ApplicationUpdated;
use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Executive;
use App\Models\HousingModel;
use App\Models\Photo;
use App\Models\Staff;
use App\Models\Subdivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $applications = new Application();

        if (isStaff()) {
            $applications = $applications->whereNull('forwardable_type')->whereNull('forwardable_id')->where('status', Application::STATUS_SUBMITTED)->orWhere('status', Application::STATUS_RESUBMIT);
        } else if (isExecutive()) {
            $applications = $applications->whereHasMorph('forwarder', [Staff::class]);
        }

        if ($request->search_by && $request->search_query) {
            switch ($request->search_by) {
                case "housing_models":
                    $applications = $applications->where('housing_model_id', $request->search_query);
                    break;
                case "subdivisions":
                    $applications = $applications->where('subdivision_id', $request->search_query);
                    break;
                case "islands":
                    $applications = $applications->where('island', $request->search_query);
                    break;
                case "industries":
                    $applications = $applications->where('industry', $request->search_query);
                    break;
                case "statuses":
                    $applications = $applications->where('status', $request->search_query);
                    break;
                case "fname":
                case "lname":
                case "email":
                case "phone":
                case "nib_no":
                    $applications = $applications->where($request->search_by, "like", "%" . $request->search_query . "%");
                    break;
                default:
                    $applications = [];
            }
        }

        return response()->json($applications->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreApplicationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        $application = auth()->user()->applications()->create($validated);

        $application->addMediaFromRequest('nib_photo')->toMediaCollection('nib_photo');
        $application->addMediaFromRequest('pre_approved_letter_photo')->toMediaCollection('pre_approved_letter_photo');
        $application->addMediaFromRequest('job_letter_document')->toMediaCollection('job_letter_document');
        if ($request->has('passport_photo')) {
            $application->addMediaFromRequest('passport_photo')->toMediaCollection('passport_photo');
        }

        Mail::to(auth()->user())->send(new ApplicationSubmitted());

        return response()->json($application);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        $application->load(['subdivision', 'housingModel']);
        return response()->json($application);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateApplicationRequest $request
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $application->update($request->validated());

        Mail::to($application->user)->send(new ApplicationUpdated($application->refresh()));

        return response()->json($application);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return response()->json(['message' => 'Application deleted.']);
    }

    public function canSubmitApplication()
    {
        $application = auth()->user()->applications()->latest()->first();

        if ($application && ($application->status == 'submitted' || $application->status == 'reviewing')) {
            return response()->json(['canSubmit' => false]);
        }
        return response()->json(['canSubmit' => true]);
    }

    public function getApplicationStatus()
    {
        $application = auth()->user()->applications()->latest('created_at')->first();

        if ($application) {
            return response()->json(['status' => $application->status, 'comments' => $application->comments]);
        } else {
            return response()->json(['status' => "undefined"]);
        }
    }

    public function forward(Application $application)
    {
        $application->forwarder()->associate(auth()->user());
        $application->status = Application::STATUS_REVIEWING;
        $application->save();
        return response()->json($application);
    }



    public function getFilterQueries()
    {
        $housingModels = HousingModel::all()->map(function ($housingModel) {
            return [
                "key" => $housingModel->id,
                "value" => $housingModel->heading
            ];
        });

        $subdivisions = Subdivision::all()->map(function ($subdivision) {
            return [
                "key" => $subdivision->id,
                "value" => $subdivision->heading
            ];
        });

        $industries = Application::select('industry')->distinct()->get()->map(function ($application) {
            return [
                "key" => $application->industry,
                "value" => $application->industry
            ];
        });

        $islands = Application::select('island')->distinct()->get()->map(function ($application) {
            return [
                "key" => $application->island,
                "value" => $application->island
            ];
        });

        $statuses = [
            [
                "key" => "submitted",
                "value" => "Submitted"
            ],
            [
                "key" => "reviewing",
                "value" => "Reviewing"
            ],
            [
                "key" => "resubmit",
                "value" => "Resubmit"
            ], [
                "key" => "approved",
                "value" => "Approved"
            ], [
                "key" => "declined",
                "value" => "Declined"
            ],
        ];

        return response()->json([
            'housing_models' => $housingModels,
            'subdivisions' => $subdivisions,
            'industries' => $industries,
            'islands' => $islands,
            'statuses' => $statuses
        ]);
    }


    public function resubmit(Application $application)
    {
        $application->status = Application::STATUS_RESUBMIT;
        $application->forwardable_type  =NULL;
        $application->forwardable_id  =NULL;
        $application->save();
        return response()->json($application);
    }
}
