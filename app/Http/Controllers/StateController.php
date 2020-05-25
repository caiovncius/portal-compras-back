<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"States"},
     *     path="/states",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/StateResource"),
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function allStates()
    {
        return StateResource::collection(State::allStates());
    }
}
