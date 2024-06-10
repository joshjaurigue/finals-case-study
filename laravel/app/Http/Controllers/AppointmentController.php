<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // View all appointments (admin)
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->get();
        return response()->json($appointments);
    }

    // Create a new appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:scheduled',
        ]);
    
        $appointment = Appointment::create($validated);
    
        return response()->json($appointment, 201);
    }

    // View appointments of a specific patient
    public function patientAppointments()
    {
        $patientId = Auth::user()->patient->id;
        $appointments = Appointment::where('patient_id', $patientId)->get();
        return response()->json($appointments);
    }

    // Cancel an appointment as a patient
    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure the logged-in user is the owner of the appointment
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Only allow cancellation if the appointment is scheduled and the date is in the future
        if ($appointment->status === 'scheduled' && Carbon::parse($appointment->appointment_date)->isFuture()) {
            $appointment->update(['status' => 'cancelled']);
            return response()->json($appointment);
        }

        return response()->json(['error' => 'Unable to cancel appointment'], 400);
    }

    // View details of a specific appointment (admin)
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
        return response()->json($appointment);
    }

    // Update an appointment as a patient (reschedule)
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure the logged-in user is the owner of the appointment
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the new appointment date
        $validated = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        // Only allow rescheduling if the appointment is scheduled and the date is in the future
        if ($appointment->status === 'scheduled' && Carbon::parse($appointment->appointment_date)->isFuture()) {
            $appointment->update($validated);
            return response()->json($appointment);
        }

        return response()->json(['error' => 'Unable to update appointment'], 400);
    }

    // Delete an appointment as a doctor
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure the logged-in user is the owner of the appointment
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }

    // View appointments of a specific doctor
    public function doctorAppointments()
    {
        $doctorId = Auth::user()->doctor->id;
        $appointments = Appointment::where('doctor_id', $doctorId)->with('patient')->get();
        return response()->json($appointments);
    }

    // Update the status of an appointment as a doctor
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure the logged-in user is the owner of the appointment
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $appointment->update($validated);

        return response()->json($appointment);
    }
}
