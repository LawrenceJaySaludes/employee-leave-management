<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);

        }

        $token = $user->createToken('employee_leave_token')->plainTextToken;

        return response()->json([

            'success' => true,

            'message' => 'Login successful.',

            'token' => $token,

            'user' => $user

        ]);

    }
}