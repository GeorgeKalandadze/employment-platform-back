<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateAsCompanyRequest;
use App\Http\Requests\CourseCreateAsUserRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('subCategory')->get();

        return CourseResource::collection($courses);
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

        if (! $company || $company->user_id !== $user->id) {
            return response()->json(['error' => 'You are not authorized to create a course under this company.'], 403);
        }
        $company->courses()->create($validatedData);

        return response()->json(['message' => 'Course created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): JsonResource
    {
        $course->load('subCategory');

        return new CourseResource($course);
    }

    public function getUserCourses()
    {
        $user = Auth::user();
        $courses = $user->courses()->with('subCategory')->get();

        return CourseResource::collection($courses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, Course $course): JsonResponse
    {
        if (! $this->checkAuthorization($course)) {
            return response()->json(['error' => 'You are not authorized to update this course.'], 403);
        }

        $validatedData = $request->validated();

        $course->update($validatedData);

        return response()->json(['message' => 'Course updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course)
    {
        if (! $this->checkAuthorization($course)) {
            return response()->json(['error' => 'You are not authorized to delete this course.'], 403);
        }

        $course->delete();

        return response()->json(['message' => 'course deleted successfully'], 200);
    }

    /**
     * Check authorization for the given course.
     */
    private function checkAuthorization(Course $course): bool
    {
        $user = auth()->user();
        if ($course->courseable_type === 'App\\Models\\Company' && $course->courseable->user_id !== $user->id) {
            return false;
        } elseif ($course->courseable_type === 'App\\Models\\User' && $course->courseable_id !== $user->id) {
            return false;
        }

        return true;
    }
}
