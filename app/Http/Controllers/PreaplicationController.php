<?php

namespace App\Http\Controllers;

use App\Models\Preaplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PreaplicationController extends Controller
{
    public function index()
    {

        $checkApplication = Preaplication::where('user_id', auth()->user()->id)->get();
        return response()->json($checkApplication, 201);
    }

    public function store(Request $request)
    {

        $preaplication = new Preaplication();

        $checkApplication = Preaplication::where('user_id', auth()->user()->id)->first();

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
}
