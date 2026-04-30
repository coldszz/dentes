<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Review;

class ReviewController extends Controller
{
    public function doctorReviews($doctorId)
    {
        $doctor = Doctor::with('user')->findOrFail($doctorId);
        $reviews = Review::where('doctor_id', $doctorId)
            ->with('patient.user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $averageRating = $doctor->reviews()->avg('rating') ?? 0;
        
        return response()->json([
            'reviews' => $reviews,
            'average_rating' => (float)$averageRating,
            'total_reviews' => $reviews->count()
        ]);
    }
}