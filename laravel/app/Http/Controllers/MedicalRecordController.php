<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
class MedicalRecordController extends Controller
{
    public function index()
    {
        // Your teammates will implement the logic to get all medical records here.
    }

    public function store(Request $request)
    {
        // Your teammates will implement the logic to create a new medical record here.
    }

    public function show($id)
    {
        // Your teammates will implement the logic to get a single medical record here.
    }

    public function update(Request $request, $id)
    {
        // Your teammates will implement the logic to update a medical record here.
    }

    public function destroy($id)
    {
        // Your teammates will implement the logic to delete a medical record here.
    }
}
