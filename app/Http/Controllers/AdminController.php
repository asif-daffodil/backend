<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\preaplication;
use App\Models\application;

class AdminController extends Controller
{
    public function get_pre_applicant($page, $limit)
    {
        $pre_applicant = Preaplication::where('application_status', 'Pending')->paginate($limit, ['*'], 'page', $page);
        return response()->json($pre_applicant);
    }

    public function approve_pre_applicant($id, $status)
    {
        $pre_applicant = Preaplication::find($id);
        $pre_applicant->application_status = $status;
        $pre_applicant->save();
        return response()->json(
            [
                'message' => 'Application status updated successfully',
                'pre_applicant' => $pre_applicant
            ]
        );
    }

    public function waiting_applicant($page, $limit){
        // slect from preapplication where application_status = 'Approved' and user_id not in application
        $waiting_applicant = Preaplication::where('application_status', 'Approved')->whereNotIn('user_id', function($query){
            $query->select('user_id')->from('applications');
        })->paginate($limit, ['*'], 'page', $page);

        return response()->json($waiting_applicant);
    }

    public function get_applicant($page, $limit){
        $pre_applicant = Application::where('application_status', 'Pending')->paginate($limit, ['*'], 'page', $page);
        return response()->json($pre_applicant);
    }

    public function approve_applicant($id, $status)
    {
        $applicant = Application::find($id);
        $applicant->application_status = $status;
        $applicant->save();
        return response()->json(
            [
                'message' => 'Application status updated successfully',
                'applicant' => $applicant
            ]
        );
    }
}
