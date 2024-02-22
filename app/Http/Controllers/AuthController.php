<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $user = new User();
        $checkEmail = $user->where('email', $request->email)->first();
        if ($checkEmail) {
            return response()->json([
                'message' => 'User already exists'
            ], 201);
        }

        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->role = $request->role ?? 'user';
        $user->phone = $request->phone;
        $user->parent_phone = $request->parent_phone;
        $user->month = $request->month;
        $user->day = $request->day;
        $user->year = $request->year;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'User successfully logged in',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout()
    {

        return response()->json([
            'message' => 'User successfully logged out'
        ]);
    }

    public function updateFirstPart()
    {
        $user = auth()->user();

        $user->firstName = request('firstName');
        $user->lastName = request('lastName');
        $user->month = request('month');
        $user->day = request('day');
        $user->year = request('year');

        $user->save();

        return response()->json([
            'message' => 'User successfully updated',
            'user' => $user
        ], 201);
    }
}
