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

    /**
     *
     * @OA\Post(
     *     tags={"Users"},
     *     path="/users",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Usuário criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     *     )
     * )
     */

    /**
     * @param UserCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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
