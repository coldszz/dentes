<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = Auth::user()->patient;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user', 'service', 'review'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        
        $myReviewsCount = Review::where('patient_id', $patient->id)->count();
        
        return view('patient.dashboard', compact('patient', 'appointments', 'myReviewsCount'));
    }
    
    public function doctors()
    {
        $doctors = Doctor::with('user')->get();
        return view('patient.doctors', compact('doctors'));
    }
    
    public function doctorsPublic()
    {
        $doctors = Doctor::with('user')->get();
        $services = Service::all();
        return view('patient.doctors', compact('doctors', 'services'));
    }
    
    public function doctorSchedule($doctorId)
    {
        $doctor = Doctor::with('user')->findOrFail($doctorId);
        $services = Service::all();
        return view('patient.book', compact('doctor', 'services'));
    }
    
    public function doctorSchedulePublic($doctorId)
    {
        $doctor = Doctor::with('user')->findOrFail($doctorId);
        $services = Service::all();
        return view('patient.book', compact('doctor', 'services'));
    }
    
    public function getAvailableSlots(Request $request)
    {
        $doctor = Doctor::findOrFail($request->doctor_id);
        
        if ($request->has('service_id') && $request->service_id > 0) {
            $service = Service::find($request->service_id);
            $duration = $service ? $service->duration_minutes : 60;
        } else {
            $duration = 60;
        }
        
        // Простая заглушка для демонстрации
        $slots = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
        
        return response()->json(['slots' => $slots]);
    }
    
    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);
        
        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $service = Service::findOrFail($validated['service_id']);
        
        $price = $service->base_price;
        
        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $validated['doctor_id'],
            'service_id' => $validated['service_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'duration_minutes' => $service->duration_minutes,
            'final_price' => $price,
            'status' => 'pending'
        ]);
        
        return redirect()->route('patient.dashboard')->with('success', 'Запись создана');
    }
    
    public function cancelAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            abort(403);
        }
        $appointment->update(['status' => 'cancelled']);
        return response()->json(['success' => true]);
    }
    
    public function rescheduleAppointment($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            abort(403);
        }
        
        $appointment->update([
            'appointment_date' => $request->new_date,
            'appointment_time' => $request->new_time,
            'status' => 'pending'
        ]);
        
        return response()->json(['success' => true]);
    }
    
    public function addReview($id, Request $request)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->patient_id !== Auth::user()->patient->id) {
            abort(403);
        }
        
        Review::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
        
        return response()->json(['success' => true]);
    }
}