<?php

namespace App\Http\Controllers;

use App\Models\application;
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

        $application = new application();

        $checkApplication = application::where('user_id', auth()->user()->id)->first();

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

        $application->save();

        return response()->json([
            'message' => 'Application successfully registered, Please upload your documents now',
            'application' => $application
        ], Response::HTTP_CREATED);
    }

    public function updatePayment (Request $request)
    {
        $request->validate([
            'transection_details' => 'required',
            'screenshot' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048'
        ]);

        $application = application::where('user_id', auth()->user()->id)->first();

        $application->transection_details = $request->transection_details;
        $application->screenshot = $request->file('screenshot')->store('documents');

        $application->save();

        return response()->json([
            'message' => 'Payment details successfully uploaded',
            'application' => $application
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, application $application)
    {
        $request->validate([
            'ssc' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048',
            'hsc' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048',
            'passport' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048',
            'photo' => 'required | mimes:jpeg,png,jpg,gif,bmp | max:2048'
        ]);

        $application = application::where('user_id', auth()->user()->id)->first();

        $application->ssc = $request->file('ssc')->store('documents');
        $application->hsc = $request->file('hsc')->store('documents');
        $application->passport = $request->file('passport')->store('documents');
        $application->photo = $request->file('photo')->store('documents');

        $application->save();

        return response()->json([
            'message' => 'Documents successfully uploaded',
            'application' => $application
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(application $application)
    {
        //
    }
}
