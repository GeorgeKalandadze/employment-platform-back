<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacancyRequest;
use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $vacancies = Vacancy::with('subCategory', 'jobType')->get();

        return VacancyResource::collection($vacancies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVacancyRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $vacancyableType = $requestData['vacancyable_type'];
        $vacancyableId = $requestData['vacancyable_id'];
        $vacancyable = null;

        if ($vacancyableType === 'App\Models\User') {
            $vacancyable = User::find($vacancyableId);
        } elseif ($vacancyableType === 'App\Models\Company') {
            $vacancyable = Company::find($vacancyableId);
        }

        // Ensure the entity exists
        if (! $vacancyable) {
            return response()->json(['error' => 'Invalid vacancyable_id or vacancyable_type'], 400);
        }

        $vacancy = new Vacancy();
        $vacancy->fill($requestData);
        $vacancyable->vacancies()->save($vacancy);

        return response()->json(['message' => 'Vacancy created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vacancy $vacancy)
    {
        return new VacancyResource($vacancy);
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
