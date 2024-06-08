<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;

class SpecializationController extends Controller
{
    // Fetch all specializations
    public function index()
    {
        $specializations = Specialization::all();
        return response()->json($specializations);
    }

    // Create a new specialization
    public function store(Request $request)
    {
        $request->validate([
            'specialization_title' => 'required|string|max:255|unique:specialization,specialization_title'
        ]);

        $specialization = Specialization::create($request->all());

        return response()->json([
            'message' => 'Specialization created successfully',
            'specialization' => $specialization
        ], 201);
    }

    // Update an existing specialization
    public function update(Request $request, $id)
    {
        $request->validate([
            'specialization_title' => 'required|string|max:255|unique:specialization,specialization_title,'.$id
        ]);

        $specialization = Specialization::findOrFail($id);
        $specialization->update($request->all());

        return response()->json([
            'message' => 'Specialization updated successfully',
            'specialization' => $specialization
        ], 200);
    }

    public function show($id) {
        // Find the user by ID
       $specialization  = Specialization::find($id);

       // Check if the user exists
       if (!$specialization) {
           return response()->json([
               'success' => false,
               'message' => 'User not found.'
           ], 404);
       }

       // Return the user's details
       return response()->json([
           'success' => true,
           'specialization_data' => $specialization 
       ], 200);
    }
    // Delete a specialization
    public function destroy($id)
    {
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();

        return response()->json([
            'message' => 'Specialization deleted successfully'
        ], 200);
    }
}
