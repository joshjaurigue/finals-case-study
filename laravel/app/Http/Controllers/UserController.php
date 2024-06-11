<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Specialization;
class UserController extends Controller
{   
    // View all users for admin
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Create a new user for admin
    public function store(Request $request)
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

    // View user details for admin
    public function show($id)
    {
       // Find the user by ID
       $user = User::find($id);

       // Check if the user exists
       if (!$user) {
           return response()->json([
               'success' => false,
               'message' => 'User not found.'
           ], 404);
       }

       // Return the user's details
       return response()->json([
           'success' => true,
           'user_data' => $user
       ], 200);
    }

    // Edit user details for admin
    public function update(Request $request, $id)
{
    // Validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'role' => 'required|string|in:admin,doctor,patient'
    ];

    // Custom error messages (optional)
    $messages = [
        'name.required' => 'Name is required.',
        'email.required' => 'Email is required.',
        'email.email' => 'Email must be a valid email address.',
        'email.unique' => 'Email has already been taken.',
        'role.required' => 'Role is required.',
        'role.in' => 'Role must be either admin, doctor, or patient.'
    ];

    // Validate the request data
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Find the user by ID
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.'
        ], 404);
    }

    // Check if the role is changing and handle related records
    if ($user->role !== $request->input('role')) {
        if ($user->role === 'doctor' && $request->input('role') === 'patient') {
            // Delete record from doctors table and add to patients table
            Doctor::where('user_id', $id)->delete();
            Patient::create([
                'user_id' => $id,
                // Add other necessary patient fields here
            ]);
        } elseif ($user->role === 'patient' && $request->input('role') === 'doctor') {
            // Find the specialization_id where the title is "None"
            $specialization = Specialization::where('specialization_title', 'None')->first();
            Patient::where('user_id', $id)->delete();
            Doctor::create([
                'user_id' => $id,
                'specialization_id' => $specialization->id
            ]);
        }
    }

    // Update the user's details
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->role = $request->input('role');

    // Save the changes to the database
    $user->save();

    // Return a success response
    return response()->json([
        'success' => true,
        'message' => 'User updated successfully.',
        'data' => $user
    ], 200);
}


    // Delete a user for admin
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Get counts of total users, doctors, and patients
    public function getCounts()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();

        return response()->json([
            'totalUsers' => $totalUsers,
            'totalDoctors' => $totalDoctors,
            'totalPatients' => $totalPatients,
        ]);
    }

     // Fetch all specializations
     public function getSpecializations()
     {
         $specializations = Specialization::all();
         return response()->json($specializations);
     }
}
