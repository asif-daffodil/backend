<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preaplication;
use App\Models\Application;

class AdminController extends Controller
{
    public function get_pre_applicant($page, $limit)
    {
        $pre_applicant = Preaplication::where('application_status', '=', 'Pending')->paginate($limit, ['*'], 'page', $page)->load('user');
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

    public function waiting_applicant($page, $limit)
    {
        // slect from preapplication where application_status = 'Approved' and user_id not in application
        $waiting_applicant = Preaplication::where('application_status', 'Approved')->whereNotIn('user_id', function ($query) {
            $query->select('user_id')->from('applications');
        })->paginate($limit, ['*'], 'page', $page)->load('user');

        return response()->json($waiting_applicant);
    }

    public function get_applicant($page, $limit)
    {
        $pre_applicant = Application::where('application_status', 'Pending')->paginate($limit, ['*'], 'page', $page)->load('user');
        return response()->json($pre_applicant);
    }

    public function approve_applicant($id, $status)
    {
        $applicant = Application::find($id);
        if ($applicant->application_status == 'Approved') {
            $status = 'Paid';
        }
        $applicant->application_status = $status;
        $applicant->save();
        return response()->json(
            [
                'message' => 'Application status updated successfully',
                'applicant' => $applicant
            ]
        );
    }

    public function get_individual_applicant($id)
    {
        $applicant = Application::find($id)->load('user');
        return response()->json($applicant);
    }

    public function get_approved_applicant($page, $limit)
    {
        $approved_applicant = Application::where('application_status', 'Approved')->paginate($limit, ['*'], 'page', $page)->load('user');
        return response()->json($approved_applicant);
    }

    public function get_paid_applicant($page, $limit)
    {
        $paid_applicant = Application::where('application_status', 'Paid')->paginate($limit, ['*'], 'page', $page)->load('user');
        return response()->json($paid_applicant);
    }

    public function get_individual_pre_applicant($id)
    {
        $pre_applicant = Preaplication::find($id)->load('user');
        return response()->json($pre_applicant);
    }

    public function get_all_paid_applicant()
    {
        // Retrieve all applicants with 'Paid' application status
        $paid_applicants = Preaplication::where('application_status', 'Paid')
            ->with(['user'])
            ->get();

        return response()->json([
            'message' => 'All Paid Students',
            'data' => $paid_applicants
        ], 200);
    }
}
