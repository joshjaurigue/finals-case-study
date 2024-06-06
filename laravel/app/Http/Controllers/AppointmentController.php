<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
class AppointmentController extends Controller
{
    // taga view ng appointments 
    public function index()
    {

    }

     // taga create ng appointments
    public function store(Request $request)
    {
      
    }
    // taga view ng details ng appointments
    public function show($id)
    {
        
    }
    // taga update ng status ng appointment kung pending, attended, or cancelled
    public function update(Request $request, $id)
    {
       
    }
     // taga delete ng appointment
    public function destroy($id)
    {
        
    }
}
