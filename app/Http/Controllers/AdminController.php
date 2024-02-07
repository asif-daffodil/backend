<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\preaplication;

class AdminController extends Controller
{
    public function get_pre_applicant($page, $limit)
    {
        $pre_applicant = Preaplication::where('application_status', 'Pending')->paginate($limit, ['*'], 'page', $page);
        return response()->json($pre_applicant);
    }
}
