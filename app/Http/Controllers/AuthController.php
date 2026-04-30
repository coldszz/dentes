<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->isAdmin()) return redirect()->intended('/admin');
            if ($user->isDoctor()) return redirect()->intended('/doctor/dashboard');
            return redirect()->intended('/patient/dashboard');
        }
        
        return back()->withErrors(['email' => 'Неверный email или пароль']);
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'patient'
        ]);
        
        // Создаём профиль пациента
        $nameParts = explode(' ', $validated['name'], 2);
        Patient::create([
            'user_id' => $user->id,
            'last_name' => $nameParts[0] ?? '',
            'first_name' => $nameParts[1] ?? '',
            'patronymic' => null
        ]);
        
        Auth::login($user);
        
        return redirect('/patient/dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}