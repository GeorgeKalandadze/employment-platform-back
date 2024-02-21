<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacancyAsCompanyRequest;
use App\Http\Requests\StoreVacancyAsUserRequest;
use App\Http\Requests\UpdateVacancyRequest;
use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
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
    public function update(UpdateVacancyRequest $request, Vacancy $vacancy): JsonResponse
    {
        if (! $this->checkAuthorization($vacancy)) {
            return response()->json(['error' => 'You are not authorized to update this vacan$vacancy.'], 403);
        }

        $vacancy->update($request->validated());

        return response()->json(['message' => 'Vacancy updated successfully'], 200);
    }

    public function destroy(Vacancy $vacancy)
    {
        if (! $this->checkAuthorization($vacancy)) {
            return response()->json(['error' => 'You are not authorized to delete this vaca$vacancy.'], 403);
        }

        $vacancy->delete();

        return response()->json(['message' => 'Vacancy deleted successfully'], 200);
    }

    /**
     * Check authorization for the given course.
     */
    private function checkAuthorization(Vacancy $vacancy): bool
    {
        $user = auth()->user();
        if ($vacancy->courseable_type === 'App\\Models\\Company' && $vacancy->courseable->user_id !== $user->id) {
            return false;
        } elseif ($vacancy->courseable_type === 'App\\Models\\User' && $vacancy->courseable_id !== $user->id) {
            return false;
        }

        return true;
    }

    public function toggleFavoriteVacancy(Vacancy $vacancy): JsonResponse
    {
        $user = auth()->user();

        $existingFavorite = $user->favorites()->where('favoritable_id', $vacancy->id)
            ->where('favoritable_type', Vacancy::class)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();

            return response()->json(['message' => 'Vacancy removed from favorites']);
        } else {
            $user->favorites()->create([
                'favoritable_id' => $vacancy->id,
                'favoritable_type' => Vacancy::class,
            ]);

            return response()->json(['message' => 'Vacancy added to favorites']);
        }
    }
}
