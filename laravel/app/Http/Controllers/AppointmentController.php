<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    // View all appointments (admin)
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user', 'doctor.specialization'])->get();
        return response()->json($appointments);
    }

    // Create a new appointment
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        // Check for existing appointment on the same date for the same doctor
        $existingAppointment = Appointment::where('appointment_date', $request->appointment_date)
            ->where('doctor_id', $request->doctor_id)
            ->exists();

        if ($existingAppointment) {
            return response()->json(['message' => 'An appointment already exists for this date with the selected doctor.'], 409);
        }

        // Create a new appointment
        $appointment = Appointment::create($validated);

        // Return the created appointment details
        return response()->json($appointment, 201);
    }

    // View appointments of a specific patient
    public function patientAppointments()
    {
        $patientId = Auth::user()->patient->id;
        // Fetch appointments for the patient with doctor, patient, and user relationships
        $appointments = Appointment::where('patient_id', $patientId)
            ->with(['patient.user', 'doctor.user', 'doctor.specialization'])
            ->get();

        // Format the response
        $formattedAppointments = $appointments->map(function ($appointment) {
            return [
                'appointment' => $appointment,
                'patient' => $appointment->patient,
                'doctor' => $appointment->doctor,
                'user_name' => $appointment->doctor->user->name,
                'specialization' => $appointment->doctor->specialization
            ];
        });

        return response()->json($formattedAppointments);
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
    public function rescheduleAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        // Run the validator
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Only allow rescheduling if the appointment is scheduled and the date is in the future
        if ($appointment->status === 'scheduled') {
            $appointment->update(['appointment_date' => $request->appointment_date]);
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
        // Fetch appointments for the patient with doctor, patient, and user relationships
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->with(['patient.user', 'doctor.user', 'doctor.specialization'])
            ->get();

        // Format the response
        $formattedAppointments = $appointments->map(function ($appointment) {
            return [
                'appointment' => $appointment,
                'patient' => $appointment->patient,
                'doctor' => $appointment->doctor,
                'user_name' => $appointment->patient->user->name,
            ];
        });

        return response()->json($formattedAppointments);
    }

    // Update the status of an appointment as a doctor
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure the logged-in user is the owner of the appointment
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $appointment->update(['status' => 'completed']);

        return response()->json($appointment);
    }
}
