<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreatorRequest;
use App\User\Contratcs\UserCreatorable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserCreatorable
     */
    private $creatorService;

    public function __construct()
    {
        $this->creatorService = app()->make(UserCreatorable::class);
    }

    public function store(UserCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Usuário criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
