<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', MedicalRecord::class);
        return MedicalRecord::all();
    }

    // public function show($id)
    // {
    //     $record = MedicalRecord::findOrFail($id);
    //     $this->authorize('view', $record);
    //     return $record;
    // }
    public function getAdminRecords()
    {
        $records = DB::table('medical_records')
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->join('doctors', 'medical_records.doctor_id', '=', 'doctors.id')
            ->join('users as patient_users', 'patients.user_id', '=', 'patient_users.id')
            ->join('users as doctor_users', 'doctors.user_id', '=', 'doctor_users.id')
            ->select(
                'medical_records.id',
                'medical_records.type',
                'medical_records.record',
                'medical_records.record_date',
                'patient_users.name as patient_name', 
                'doctor_users.name as doctor_name', 
            )
            ->get();
    
        return response()->json($records);
    }
    
    
        public function getPatientRecords($patientId)
        {
            $records = DB::table('medical_records')
                ->where('medical_records.patient_id', $patientId)
                ->join('doctors', 'medical_records.doctor_id', '=', 'doctors.id')
                ->select(
                    'medical_records.id',
                'medical_records.type',
                'medical_records.record',
                'medical_records.record_date',
                DB::raw("CONCAT(doctors.first_name, IF(doctors.middle_name IS NOT NULL AND doctors.middle_name != '', CONCAT(' ', doctors.middle_name), ''), IF(doctors.last_name IS NOT NULL AND doctors.last_name != '', CONCAT(' ', doctors.last_name), '')) as doctor_full_name")
                )
            ->get();
    
        return response()->json($records);
    }
    public function getDoctorRecords($doctorId)
    {
        $records = DB::table('medical_records')
            ->where('medical_records.doctor_id', $doctorId)
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->select(
                'medical_records.id',
                'medical_records.type',
                'medical_records.record',
                'medical_records.record_date',
                'users.name',
            )
            ->get();
    
        return response()->json($records);
    }

    public function getRecordById($recordId)
    {
        $records = DB::table('medical_records')
            ->where('medical_records.id', $recordId)
            ->join('patients', 'medical_records.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->select(
                'medical_records.id',
                'medical_records.type',
                'medical_records.record',
                'medical_records.record_date',
                'users.name',
            )
            ->get();
    
        return response()->json($records);
    }


    public function updateRecord(Request $request, $recordId)
    {
        $validated = $request->validate([
            'type' => 'string', // Modify this validation rule according to your needs
            'record_date' => 'date', // Modify this validation rule according to your needs
            'record' => 'string', // Modify this validation rule according to your needs
        ]);
    
        $record = DB::table('medical_records')
            ->where('id', $recordId)
            ->first();
        
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }
    
        $updateData = [];
    
        if ($request->has('type')) {
            $updateData['type'] = $validated['type'];
        }
    
        if ($request->has('record_date')) {
            $updateData['record_date'] = $validated['record_date'];
        }
    
        if ($request->has('record')) {
            $updateData['record'] = $validated['record'];
        }
    
        DB::table('medical_records')
            ->where('id', $recordId)
            ->update($updateData);
    
        $updatedRecord = DB::table('medical_records')
            ->where('id', $recordId)
            ->first();
    
        return response()->json(['message' => 'Record updated successfully', 'record' => $updatedRecord], 200);
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
