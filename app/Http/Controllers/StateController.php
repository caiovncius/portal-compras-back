<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function allStates()
    {
        return StateResource::collection(State::allStates());
    }
}
