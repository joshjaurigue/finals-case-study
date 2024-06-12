<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PatientController extends Controller
{
    // Retrieve all patients
    public function index()
    {
        $patients = Patient::with('user')->get();
        return response()->json($patients);
    }

    // Create a new patient
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'place_of_birth' => 'required',
            'age' => 'required|integer|min:0',
            'sex' => 'required|in:Male,Female',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'patient',
        ]);

        $patient = Patient::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'age' => $request->age,
            'sex' => $request->sex,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json($patient, 201);
    }

    // View details of a specific patient
    public function show(Request $request, $id)
    {
        try {
            // Attempt to find the patient by ID and load the related user details
            $patient = Patient::with('user')->findOrFail($id);

            // Return the patient details as a JSON response
            return response()->json($patient);
        } catch (ModelNotFoundException $e) {
            // If no patient is found, return a 404 error response
            return response()->json(['message' => 'Patient not found'], 404);
        }
    }

    // View details of a specific patient's diagnosis
    public function showDiagnosis(Request $request, $id)
    {
        try {
            // Attempt to find the patient by ID
            $patient = Patient::findOrFail($id);

            // Return only the diagnosis field as a JSON response
            return response()->json(['diagnosis' => $patient->diagnosis]);
        } catch (ModelNotFoundException $e) {
            // If no patient is found, return a 404 error response
            return response()->json(['message' => 'Patient not found'], 404);
        }
    }

    // Update details of a patient
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'name' => ['required', Rule::unique('users')->ignore($patient->user_id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($patient->user_id)],
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'place_of_birth' => 'required',
            'age' => 'required|integer|min:0',
            'sex' => 'required|in:Male,Female',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $user = $patient->user;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $patient->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'age' => $request->age,
            'sex' => $request->sex,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json($patient, 201);
    }

    // Delete a patient
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        $patient->delete();
        $user->delete();

        return response()->json(null, 204);
    }

    // View all patients for the doctor
    public function patientList(Request $request)
    {
        $doctor_id = auth()->user()->doctor->id;

        // Retrieve patients associated with the doctor via appointments
        $patients = Appointment::where('doctor_id', $doctor_id)->with('patient')->get();

        // Check if any patients are found
        if ($patients->isEmpty()) {
            return response()->json(['message' => 'No patients found'], 200);
        }

        return response()->json($patients);
    }

    // Update patient details
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'diagnosis' => 'required|string|max:255',
        ]);

        $patient = Patient::findOrFail($id);

        if (!$request->user()->appointments->contains('patient_id', $id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $patient->update($request->only(['diagnosis']));

        return response()->json($patient);
    }
}
