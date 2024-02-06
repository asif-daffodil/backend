<?php

namespace App\Http\Controllers;

use App\Models\preaplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PreaplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $checkApplication = preaplication::where('user_id', auth()->user()->id)->get();
        return response()->json($checkApplication, 201);
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

        $preaplication = new preaplication();

        $checkApplication = preaplication::where('user_id', auth()->user()->id)->first();

        if ($checkApplication) {
            return response()->json([
                'message' => 'You already have an application'
            ], 201);
        }

        $preaplication->user_id = auth()->user()->id;
        $preaplication->russain_citizen = $request->russain_citizen;
        $preaplication->permanent_resident = $request->permanent_resident;
        $preaplication->location = $request->location;

        $preaplication->save();

        return response()->json([
            'message' => 'Preaplication successfully registered',
            'preaplication' => $preaplication
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(preaplication $preaplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(preaplication $preaplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, preaplication $preaplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(preaplication $preaplication)
    {
        //
    }
}
