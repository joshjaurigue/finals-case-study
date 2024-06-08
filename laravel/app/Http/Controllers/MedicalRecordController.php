<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
class MedicalRecordController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', MedicalRecord::class);
        return MedicalRecord::all();
    }

    public function show($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $this->authorize('view', $record);
        return $record;
    }

    public function store(Request $request)
    {
        $this->authorize('create', MedicalRecord::class);
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'nullable|exists:users,id',
            'record' => 'required|string',
        ]);

        return MedicalRecord::create($validated);
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::findOrFail($id);
        $this->authorize('update', $record);

        $validated = $request->validate([
            'record' => 'required|string',
        ]);

        $record->update($validated);
        return $record;
    }

    public function destroy($id)
    {
        $record = MedicalRecord::findOrFail($id);
        $this->authorize('delete', $record);
        $record->delete();
        return response()->noContent();
    }
}
