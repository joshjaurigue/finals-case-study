<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class DoctorController extends Controller
{
    // taga view ng doctors
    public function index()
    {
        $doctors = Doctor::with('user', 'specialization')->get();
        return response()->json($doctors);
    }
    // taga create ng doctors
    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'specialization_id' => 'required|integer|exists:specialization,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'doctor',
        ]);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'specialization_id' => $validated['specialization_id'],
            'phone_number' => $validated['phone_number'],
        ]);

        return response()->json($doctor, 201);
    }

    // taga view ng details ng doctors
    public function show($id)
    {
        try {
            $doctor = Doctor::with('user', 'specialization')->findOrFail($id);
            return response()->json($doctor);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'middle_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'specialization_id' => 'sometimes|required|integer|exists:specialization,id',
            'phone_number' => 'sometimes|required|string|max:255',
            'user.name' => 'sometimes|required|string|max:255|unique:users,name,' . $user->id,
            'user.email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update the user details
        if (isset($validated['user'])) {
            $user->update([
                'name' => $validated['user']['name'] ?? $user->name,
                'email' => $validated['user']['email'] ?? $user->email,
            ]);
        }

        // Update the doctor details
        $doctor->update([
            'first_name' => $validated['first_name'] ?? $doctor->first_name,
            'middle_name' => $validated['middle_name'] ?? $doctor->middle_name,
            'last_name' => $validated['last_name'] ?? $doctor->last_name,
            'specialization_id' => $validated['specialization_id'] ?? $doctor->specialization_id,
            'phone_number' => $validated['phone_number'] ?? $doctor->phone_number,
        ]);

        return response()->json($doctor, 201);
    }
    // taga delete ng doctors
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $user = $doctor->user;

        $doctor->delete();
        $user->delete();

        return response()->json(null, 204);
    }

    // Update doctor's own profile
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $doctor = $user->doctor;

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'specialization_id' => 'sometimes|required|integer|exists:specialization,id',
            'phone_number' =>  'sometimes|required|string|max:255', // Validate the foreign key
        ]);



        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update(array_filter([
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
            'password' => $validated['password'] ?? null,
        ]));

        $doctor->update(array_filter([
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'specialization_id' => $validated['specialization_id'],
        ]));

        return response()->json($doctor, 201);
    }


    // View doctor's own appointments
    public function viewAppointments(Request $request)
    {
        $appointments = Appointment::where('doctor_id', $request->user()->id)->with(['patient.user', 'doctor.user'])->get();

        return response()->json($appointments);
    }

    // View doctor's own profile
    public function showProfile(Request $request)
    {
        $user = $request->user();
        $doctor = $user->doctor;

        return response()->json($doctor->load('user'));
    }
}
