<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\SpecializationController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DoctorMiddleware;
use App\Http\Middleware\PatientMiddleware;
use Illuminate\Http\Request;


// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Admin routes
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {

    Route::get('users', [UserController::class, 'index']);
    Route::get('dashboard', [UserController::class, 'getCounts']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::get('admin/specializations', [UserController::class, 'getSpecializations']);
    Route::post('specializations', [SpecializationController::class, 'store']);
    Route::get('admin/specializations/{id}', [SpecializationController::class, 'show']);
    Route::put('specializations/{id}', [SpecializationController::class, 'update']);
    Route::delete('specializations/{id}', [SpecializationController::class, 'destroy']);
    Route::get('admin/patients', [PatientController::class, 'index']);
    Route::post('admin/patients/create', [PatientController::class, 'store']);
    Route::get('admin/patients/{id}', [PatientController::class, 'show']);
    Route::put('admin/patients/edit/{id}', [PatientController::class, 'update']);
    Route::delete('admin/patients/delete/{id}', [PatientController::class, 'destroy']);
    Route::get('admin/doctors', [DoctorController::class, 'index']);
    Route::post('admin/doctors/create', [DoctorController::class, 'store']);
    Route::get('admin/doctors/details/{id}', [DoctorController::class, 'show']);
    Route::put('admin/doctors/edit/{id}', [DoctorController::class, 'update']);
    Route::delete('admin/doctors/{id}', [DoctorController::class, 'destroy']);
    Route::get('admin/appointments', [AppointmentController::class, 'index']);
    Route::get('admin/appointments/{id}', [AppointmentController::class, 'show']);
});

// Doctor routes
Route::middleware(['auth:sanctum', DoctorMiddleware::class])->group(function () {
    Route::get('/doctor/myPatients', [PatientController::class, 'patientList']);
    Route::get('patients/{id}/diagnosis', [PatientController::class, 'showDiagnosis']);
    Route::get('specializations/{id}', [SpecializationController::class, 'show']);
    Route::get('specializations', [SpecializationController::class, 'index']);
    Route::put('patients/{id}', [PatientController::class, 'updateStatus']);
    Route::get('doctors/my-profile', [DoctorController::class, 'showProfile']);
    Route::put('doctors/update-profile', [DoctorController::class, 'updateProfile']);
    Route::get('/doctor/appointments', [AppointmentController::class, 'doctorAppointments']);
    Route::patch('/doctor/completeAppointment/{id}', [AppointmentController::class, 'updateStatus']);
    Route::delete('/doctor/appointments/{id}', [AppointmentController::class, 'destroy']);
    Route::get('records', [MedicalRecordController::class, 'index']);
    Route::post('records', [MedicalRecordController::class, 'store']);
    Route::get('records/{id}', [MedicalRecordController::class, 'show']);
    Route::put('records/{id}', [MedicalRecordController::class, 'update']);
    Route::delete('records/{id}', [MedicalRecordController::class, 'destroy']);

});

// Patient routes
Route::middleware(['auth:sanctum', PatientMiddleware::class])->group(function () {
    Route::get('patient/doctors', [DoctorController::class, 'index']);
    Route::get('patients/{id}', [PatientController::class, 'show']);
    Route::get('patient/appointments', [AppointmentController::class, 'patientAppointments']);
    Route::post('patient/createAppointments', [AppointmentController::class, 'store']);
    Route::patch('patient/appointment/reschedule/{id}', [AppointmentController::class, 'rescheduleAppointment']);
    Route::delete('patient/cancelAppointment/{id}', [AppointmentController::class, 'cancelAppointment']);
    Route::get('/getPatientRecords/{id}', [MedicalRecordController::class, 'getPatientRecords']);
    Route::put('patient/records/{id}', [MedicalRecordController::class, 'update']);
});
