<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRateRequest;
use App\Models\Course;

class RateController extends Controller
{

    public function store(StoreRateRequest $request, Course $course)
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
