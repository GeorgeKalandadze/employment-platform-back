<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateAsUserRequest;
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
        $course = $user->courses()->create($validatedData);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
