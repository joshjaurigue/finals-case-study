<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Specialization;


class DoctorController extends Controller
{   
    // taga view ng doctors
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }
    
     // taga create ng doctors
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            // Add other validation rules as needed
        ]);

        $doctor = Doctor::create($validatedData);
        return response()->json($doctor, 201);
    }

     // taga view ng details ng doctors
    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }

     // taga update ng details ng doctors
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'specialization' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:doctors,email,' . $doctor->id,
            // Add other validation rules as needed
        ]);

        $doctor->update($validatedData);
        return response()->json($doctor);
    }

    // taga delete ng doctors 
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return response()->json(null, 204);
    }
}

