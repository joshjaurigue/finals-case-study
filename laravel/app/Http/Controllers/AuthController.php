<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|string|in:admin,doctor,patient',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Create an entry in the corresponding table based on the role
    if ($request->role === 'doctor') {
        Doctor::create([
            'user_id' => $user->id,
            'specialization_id' => 11, 
        ]);
    } elseif ($request->role === 'patient') {
        Patient::create(['user_id' => $user->id]);
    }

    return response()->json(['message' => 'User registered successfully'], 201);
}
    // for logging in users
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        $additionalData = [];
        if ($user->role === 'doctor') {
            $additionalData['doctor_id'] = $user->doctor->id;
        } elseif ($user->role === 'patient') {
            $additionalData['patient_id'] = $user->patient->id;
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'additional_data' => $additionalData
        ], 201);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}
    // for logging out users
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
