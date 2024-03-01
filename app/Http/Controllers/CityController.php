<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResourse;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityController extends Controller
{
    public function index(): ResourceCollection
    {
        $cities = City::all();

        return CityResourse::collection($cities);
    }
}
