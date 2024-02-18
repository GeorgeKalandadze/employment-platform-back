<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacancyAsCompanyRequest;
use App\Http\Requests\StoreVacancyAsUserRequest;
use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
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

    public function storeVacancyAsCompany(StoreVacancyAsCompanyRequest $request)
    {
        $validatedData = $request->validated();

        $company = Company::findOrFail($validatedData['company_id']);
        $company->vacancies()->create($validatedData);

        return response()->json(['message' => 'Vacancy created successfully'], 201);
    }

    public function storeVacancyAsUser(StoreVacancyAsUserRequest $request)
    {
        $validatedData = $request->validated();
        $userId = auth()->id();

        $user = User::findOrFail($userId);
        $user->vacancies()->create($validatedData);

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
