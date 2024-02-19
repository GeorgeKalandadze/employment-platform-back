<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateAsCompanyRequest;
use App\Http\Requests\CourseCreateAsUserRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCourseAsUser(CourseCreateAsUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = auth()->user();
        $user->courses()->create($validatedData);
        return response()->json(['message' => 'Course created successfully'], 201);
    }


    public function storeCourseAsCompany(CourseCreateAsCompanyRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = auth()->user();
        $company = $user->companies()->find($validatedData['company_id']);

        if (!$company || $company->user_id !== $user->id) {
            return response()->json(['error' => 'You are not authorized to create a course under this company.'], 403);
        }
        $company->courses()->create($validatedData);

        return response()->json(['message' => 'Course created successfully'], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): JsonResponse
    {
        $user = auth()->user();

        if ($course->courseable_type === 'App\\Models\\Company' && $course->courseable->user_id !== $user->id) {
            return response()->json(['error' => 'You are not authorized to update this course.'], 403);
        } elseif ($course->courseable_type === 'App\\Models\\User' && $course->courseable_id !== $user->id) {
            return response()->json(['error' => 'You are not authorized to update this course.'], 403);
        }
        $validatedData = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            'start_date' => 'date',
        ]);

        $course->update($validatedData);

        return response()->json(['message' => 'Course updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course)
    {

    }
}
