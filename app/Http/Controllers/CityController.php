<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Resources\CityResource;
use App\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Cities"},
     *     path="/cities/by-state/{state}",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Items(ref="#/components/schemas/CityResource"),
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function allCities(State $state)
    {
        return CityResource::collection(City::byState($state)->get());
    }
}
