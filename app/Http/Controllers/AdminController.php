<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\ServiceCategory;
use App\Models\DoctorVacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        
        $doctors = Doctor::with('user')->get();
        $appointments = Appointment::with(['patient', 'doctor', 'service'])->orderBy('appointment_date', 'desc')->get();
        $services = Service::with('category')->get();
        $patients = Patient::with('user', 'appointments')->get();
        
        return view('admin.dashboard', compact(
            'totalPatients', 'totalDoctors', 'totalAppointments', 'pendingAppointments',
            'doctors', 'appointments', 'services', 'patients'
        ));
    }
    
    public function doctors()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.doctors', compact('doctors'));
    }
    
    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'last_name' => 'required',
            'first_name' => 'required',
            'specialization' => 'required'
        ]);
        
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $request->phone,
            'role' => 'doctor'
        ]);
        
        Doctor::create([
            'user_id' => $user->id,
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'patronymic' => $request->patronymic,
            'specialization' => $validated['specialization'],
            'description' => $request->description,
            'experience_years' => $request->experience_years ?? 0,
            'default_appointment_duration' => 60
        ]);
        
        return response()->json(['success' => true]);
    }
    
    public function deleteDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->user->delete();
        return response()->json(['success' => true]);
    }
    
    public function setVacation(Request $request, $id)
    {
        DoctorVacation::create([
            'doctor_id' => $id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        
        return response()->json(['success' => true]);
    }
    
    public function confirmAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'confirmed']);
        return response()->json(['success' => true]);
    }
    
    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'cancelled']);
        return response()->json(['success' => true]);
    }
    
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(8);
        $user->update(['password' => Hash::make($newPassword)]);
        
        return response()->json(['success' => true, 'password' => $newPassword]);
    }
    
    public function appointments()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'service'])->orderBy('appointment_date', 'desc')->get();
        return view('admin.appointments', compact('appointments'));
    }
    
    public function services()
    {
        $services = Service::with('category')->get();
        $categories = ServiceCategory::all();
        return view('admin.services', compact('services', 'categories'));
    }
    
    public function storeService(Request $request)
    {
        Service::create($request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:service_categories,id',
            'base_price' => 'required|numeric',
            'duration_minutes' => 'required|integer',
            'description' => 'nullable'
        ]));
        
        return response()->json(['success' => true]);
    }
    
    public function deleteService($id)
    {
        Service::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}