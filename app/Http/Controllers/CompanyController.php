<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $companies = Company::with('vacancies', 'courses', 'user')->get();

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $user_id = auth()->id();

        $validatedData = $request->validated();

        $validatedData['user_id'] = $user_id;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');

            $validatedData['logo'] = $logoPath;
        }

        Company::create($validatedData);

        return response()->json(['message' => 'Company created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): JsonResource
    {
        $company->load('vacancies', 'courses', 'user');

        return new CompanyResource($company);
    }

    public function userCompanies(): ResourceCollection
    {

        $user = Auth::user();

        $companies = $user->companies()->with('vacancies', 'courses')->get();

        return CompanyResource::collection($companies);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, Company $company): JsonResponse
    {
        if ($company->user_id !== auth()->id()) {
            return response()->json(['error' => 'You are not authorized to update this company.'], 403);
        }

        $validatedData = $request->validated();

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }

            $logoPath = $request->file('logo')->store('company-logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $company->update($validatedData);

        return response()->json(['message' => 'Company updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        if ($company->user_id !== auth()->id()) {
            return response()->json(['error' => 'You are not authorized to delete this company.'], 403);
        }
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully'], 200);
    }



    public function toggleFollow( Company $company)
    {
        $user = auth()->user();

        if ($user->followedCompanies()->where('company_id', $company->id)->exists()) {
            $user->followedCompanies()->detach($company->id);
            return response()->json(['message' => 'You have unfollowed ' . $company->name]);
        } else {
            $user->followedCompanies()->attach($company->id);
            return response()->json(['message' => 'You are now following ' . $company->name]);
        }
    }
}
