<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Resources\CityResource;
use App\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @param State $state
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function allCities(State $state)
    {
        return CityResource::collection(City::byState($state)->get());
    }
}
