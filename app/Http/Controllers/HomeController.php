<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::take(4)->get();
        $doctors = Doctor::with('user')->take(4)->get();
        
        return view('index', compact('services', 'doctors'));
    }
}