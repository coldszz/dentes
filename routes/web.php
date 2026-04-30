<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;

// ========== ПУБЛИЧНЫЕ МАРШРУТЫ ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors', [PatientController::class, 'doctorsPublic'])->name('public.doctors');
Route::get('/doctor/{id}/schedule', [PatientController::class, 'doctorSchedulePublic'])->name('public.doctor.schedule');
Route::get('/get-available-slots', [PatientController::class, 'getAvailableSlots'])->name('get.slots');
Route::get('/doctor/{id}/reviews', [ReviewController::class, 'doctorReviews'])->name('doctor.reviews');

// ========== АУТЕНТИФИКАЦИЯ ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== ЗАЩИЩЁННЫЕ МАРШРУТЫ ==========
Route::middleware(['auth'])->group(function () {
    
    // Пациент
    Route::middleware(['patient'])->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/doctors', [PatientController::class, 'doctors'])->name('doctors');
        Route::get('/doctor/{id}/book', [PatientController::class, 'doctorSchedule'])->name('book');
        Route::post('/appointment', [PatientController::class, 'bookAppointment'])->name('appointment.store');
        Route::put('/appointment/{id}/reschedule', [PatientController::class, 'rescheduleAppointment'])->name('appointment.reschedule');
        Route::delete('/appointment/{id}', [PatientController::class, 'cancelAppointment'])->name('appointment.cancel');
        Route::post('/appointment/{id}/review', [PatientController::class, 'addReview'])->name('review.store');
    });
    
    // Врач
    Route::middleware(['doctor'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        Route::post('/schedule', [DoctorController::class, 'updateSchedule'])->name('schedule.update');
        Route::post('/appointment/{id}/duration', [DoctorController::class, 'updateAppointmentDuration'])->name('appointment.update-duration');
        Route::post('/appointment/{id}/confirm', [DoctorController::class, 'confirmAppointment'])->name('appointment.confirm');
        Route::delete('/appointment/{id}', [DoctorController::class, 'cancelAppointment'])->name('appointment.cancel');
        Route::get('/reviews', [DoctorController::class, 'reviews'])->name('reviews');
        Route::delete('/schedule/{id}', [DoctorController::class, 'deleteSchedule'])->name('schedule.delete');
        Route::post('/vacation', [DoctorController::class, 'storeVacation'])->name('vacation.store');
        Route::delete('/vacation/{id}', [DoctorController::class, 'deleteVacation'])->name('vacation.delete');
    });
    
    // Админ
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
        Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('doctors.store');
        Route::delete('/doctors/{id}', [AdminController::class, 'deleteDoctor'])->name('doctors.delete');
        Route::post('/doctors/{id}/vacation', [AdminController::class, 'setVacation'])->name('doctors.vacation');
        Route::post('/appointment/{id}/confirm', [AdminController::class, 'confirmAppointment'])->name('appointment.confirm');
        Route::post('/appointment/{id}/cancel', [AdminController::class, 'cancelAppointment'])->name('appointment.cancel');
        Route::post('/user/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('user.reset-password');
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::get('/services', [AdminController::class, 'services'])->name('services');
        Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
        Route::delete('/services/{id}', [AdminController::class, 'deleteService'])->name('services.delete');
    });
});