<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Preaplication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'applicationType' => 'required',
            'highSchool' => 'required',
            'russain_citizen' => 'required',
            'permanent_resident' => 'required'
        ]);

        $application = new Application();

        $checkApplication = Application::where('user_id', auth()->user()->id)->first();

        if ($checkApplication) {
            return response()->json([
                'message' => 'You already have an application'
            ], Response::HTTP_CONFLICT);
        }

        $application->user_id = auth()->user()->id;
        $application->applicationType = $request->applicationType;
        $application->highSchool = $request->highSchool;
        $application->russain_citizen = $request->russain_citizen;
        $application->permanent_resident = $request->permanent_resident;

        // update preapplication application_status to Applied
        $preaplication = Preaplication::where('user_id', auth()->user()->id)->first();
        $preaplication->application_status = 'Applied';
        $preaplication->save();


        $application->save();

        return response()->json([
            'message' => 'Application successfully registered, Please upload your documents now',
            'application' => $application
        ], Response::HTTP_CREATED);
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'transection_details' => 'required',
            'screenshot' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048'
        ]);

        $application = Application::where('user_id', auth()->user()->id)->first();

        $application->transection_details = $request->transection_details;
        $application->screenshot = $request->file('screenshot')->store('public');
        $application->screenshot = basename($application->screenshot);

        // update preapplication application_status to Paid
        $preaplication = Preaplication::where('user_id', auth()->user()->id)->first();
        $preaplication->application_status = 'Paid';

        $preaplication->save();

        $application->save();

        return response()->json([
            'message' => 'Payment details successfully uploaded',
            'application' => $application
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Application $application)
    {
        $request->validate([
            'ssc' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048',
            'hsc' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048',
            'passport' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048',
            'photo' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048'
        ]);

        $application = Application::where('user_id', auth()->user()->id)->first();

        $application->ssc = $request->file('ssc')->store('public');
        $application->ssc = basename($application->ssc);

        $application->hsc = $request->file('hsc')->store('public');
        $application->hsc = basename($application->hsc);

        $application->passport = $request->file('passport')->store('public');
        $application->passport = basename($application->passport);

        $application->photo = $request->file('photo')->store('public');
        $application->photo = basename($application->photo);

        $application->save();

        return response()->json([
            'message' => 'Documents successfully uploaded',
            'application' => $application
        ], Response::HTTP_CREATED);
    }

    public function get_individual_application()
    {
        $id = auth()->user()->id;
        $application = application::where('user_id', $id)->first();
        return response()->json($application);
    }
}
