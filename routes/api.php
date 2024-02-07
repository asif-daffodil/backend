<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PreaplicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/updateFirstPart', [AuthController::class, 'updateFirstPart']);
Route::middleware('auth:sanctum')->get('/checkpreaplication', [PreaplicationController::class, 'index']);
Route::middleware('auth:sanctum')->post('/preaplication', [PreaplicationController::class, 'store']);
Route::middleware('auth:sanctum')->post('/new-application', [ApplicationController::class, 'store']);
Route::middleware('auth:sanctum')->post('/upload', [ApplicationController::class, 'update']);
Route::middleware('auth:sanctum')->post('/update-payment', [ApplicationController::class, 'updatePayment']);

Route::middleware('AdminMiddleware')->get('/get-pre-applicant/{page}/{limit}', [AdminController::class, 'get_pre_applicant']);
Route::middleware('AdminMiddleware')->post('/approve-pre-applicant/{id}/{status}', [AdminController::class, 'approve_pre_applicant']);
Route::middleware('AdminMiddleware')->get('/waiting-applicant/{page}/{limit}', [AdminController::class, 'waiting_applicant']);
Route::middleware('AdminMiddleware')->get('/get-applicant/{page}/{limit}', [AdminController::class, 'get_applicant']);
Route::middleware('AdminMiddleware')->post('/approve-applicant/{id}/{status}', [AdminController::class, 'approve_applicant']);
