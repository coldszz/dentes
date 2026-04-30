<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\DoctorVacation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = Auth::user()->doctor;
        $today = date('Y-m-d');
        
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $today)
            ->with(['patient.user', 'service'])
            ->get();
        
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['patient.user', 'service'])
            ->orderBy('appointment_date')
            ->get();
        
        $upcomingSchedules = Schedule::where('doctor_id', $doctor->id)
            ->where('date', '>=', $today)
            ->orderBy('date')
            ->get();
        
        $vacations = DoctorVacation::where('doctor_id', $doctor->id)
            ->where('end_date', '>=', $today)
            ->get();
        
        $reviews = $doctor->reviews()->with('patient.user')->get();
        
        return view('doctor.dashboard', compact('doctor', 'todayAppointments', 'upcomingAppointments', 'upcomingSchedules', 'vacations', 'reviews'));
    }
    
    public function updateSchedule(Request $request)
    {
        $doctor = Auth::user()->doctor;
        
        Schedule::updateOrCreate(
            [
                'doctor_id' => $doctor->id,
                'date' => $request->date
            ],
            [
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'is_working' => $request->has('is_working')
            ]
        );
        
        return response()->json(['success' => true]);
    }
    
    public function deleteSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        if ($schedule->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        $schedule->delete();
        return response()->json(['success' => true]);
    }
    
    public function updateAppointmentDuration($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        
        $service = $appointment->service;
        $newPrice = ($service->base_price / 60) * $request->duration_minutes;
        
        $appointment->update([
            'duration_minutes' => $request->duration_minutes,
            'final_price' => $newPrice
        ]);
        
        return response()->json(['success' => true, 'new_price' => $newPrice]);
    }
    
    public function confirmAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        $appointment->update(['status' => 'confirmed']);
        return response()->json(['success' => true]);
    }
    
    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        $appointment->update(['status' => 'cancelled']);
        return response()->json(['success' => true]);
    }
    
    public function storeVacation(Request $request)
    {
        $doctor = Auth::user()->doctor;
        
        DoctorVacation::create([
            'doctor_id' => $doctor->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        
        return response()->json(['success' => true]);
    }
    
    public function deleteVacation($id)
    {
        $vacation = DoctorVacation::findOrFail($id);
        if ($vacation->doctor_id !== Auth::user()->doctor->id) {
            abort(403);
        }
        $vacation->delete();
        return response()->json(['success' => true]);
    }
    
    public function reviews()
    {
        $doctor = Auth::user()->doctor;
        $reviews = $doctor->reviews()->with('patient.user')->orderBy('created_at', 'desc')->get();
        return view('doctor.reviews', compact('reviews', 'doctor'));
    }
}