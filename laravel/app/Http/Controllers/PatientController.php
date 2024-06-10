<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // View all patients
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // Create a new patient
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'nullable|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'sex' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);
    
        // Create a new patient
        $patient = Patient::create($validatedData);
    
        return response()->json(['message' => 'Patient created successfully', 'patient' => $patient], 201);
    }

    // View details of a patient by ID
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    // Update details of a patient
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'nullable|string|max:50',
            'second_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'sex' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        // Find the patient and update their details
        $patient = Patient::findOrFail($id);
        $patient->update($validatedData);

        return response()->json($patient);
    }

    // Delete a patient
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(null, 204);
    }
}

