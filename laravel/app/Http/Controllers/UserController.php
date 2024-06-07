<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
class UserController extends Controller
{   
     // taga view ng users for admin
    public function index()
    {

    }
    // taga create ng users for admin
    public function store(Request $request)
    {
      
    }
    // taga view ng user detaild for admin
    public function show($id)
    {
        
    }
      // taga edit  ng details for admin
    public function update(Request $request, $id)
    {
       
    }
      // taga delete ng users for admin
    public function destroy($id)
    {
        
    }
    
    // counting records
    public function getCounts()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();

        \Log::info('Total Users: ' . $totalUsers);
        \Log::info('Total Doctors: ' . $totalDoctors);
        \Log::info('Total Patients: ' . $totalPatients);
        return response()->json([
            'totalUsers' => $totalUsers,
            'totalDoctors' => $totalDoctors,
            'totalPatients' => $totalPatients,
        ]);
    }
}
