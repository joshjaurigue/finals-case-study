<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PatientMiddleware;
use App\Http\Middleware\DoctorMiddleware;
use App\Http\Middleware\AdminMiddleware;




// Authentication
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('users', [UserController::class, 'index']); 
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::get('specializations', [SpecializationController::class, 'index']);
    Route::post('specializations', [SpecializationController::class, 'store']);
    Route::get('specializations/{id}', [SpecializationController::class, 'show']);
    Route::put('specializations/{id}', [SpecializationController::class, 'update']);
    Route::delete('specializations/{id}', [SpecializationController::class, 'destroy']);
});

Route::middleware([DoctorMiddleware::class])->group(function () {
    Route::get('patients', [PatientController::class, 'index']);
    Route::put('patients/{id}', [PatientController::class, 'update']);
    Route::get('doctors', [DoctorController::class, 'index']);
    Route::post('doctors', [DoctorController::class, 'store']);
    Route::get('doctors/{id}', [DoctorController::class, 'show']);
    Route::put('doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('doctors/{id}', [DoctorController::class, 'destroy']);
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::get('appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('appointments/{id}', [AppointmentController::class, 'update']);
    Route::get('records', [MedicalRecordController::class, 'index']);
    Route::post('records', [MedicalRecordController::class, 'store']);
    Route::get('records/{id}', [MedicalRecordController::class, 'show']);
    Route::put('records/{id}', [MedicalRecordController::class, 'update']);
    Route::delete('records/{id}', [MedicalRecordController::class, 'destroy']);
   
});

Route::middleware([PatientMiddleware::class])->group(function () {
    Route::get('patients/{id}', [PatientController::class, 'show']);
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::get('appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']);
    Route::get('records', [MedicalRecordController::class, 'index']);
    Route::put('records/{id}', [MedicalRecordController::class, 'update']);
});