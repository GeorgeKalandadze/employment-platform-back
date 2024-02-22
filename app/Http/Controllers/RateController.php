<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $existingRating = $course->rates()->where('user_id', auth()->id())->first();

        if ($existingRating) {
            $existingRating->delete();

            return response()->json('Rate removed!');
        }

        $course->rates()->create([
            'rating' => $request->rating,
            'user_id' => auth()->id(),
            'course_id' => $course->id,
        ]);

        return response()->json('Rate added successfully!');
    }
}
