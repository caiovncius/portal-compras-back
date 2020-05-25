<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreatorRequest;
use App\Http\Requests\UserUpdatorRequest;
use App\User;
use App\User\Contratcs\UserCreatorable;
use App\User\Contratcs\UserUpdatable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserCreatorable
     */
    private $creatorService;

    /**
     * @var UserUpdatable
     */
    private $updaterService;

    public function __construct()
    {
        $this->creatorService = app()->make(UserCreatorable::class);
        $this->updaterService = app()->make(UserUpdatable::class);
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
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 example ="Mensagem de error"
     *            )
     *         )
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


    /**
     *
     * @OA\Put(
     *     tags={"Users"},
     *     path="/users/{user}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserUpdaterRequest")
     *      ),
     *     @OA\Parameter(
     *        name="user",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Usuário atualizado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 example ="Mensagem de error"
     *            )
     *         )
     *     )
     * )
     */
    /**
     * @param UserCreatorRequest $request
     * @return mixed
     */
    public function update(User$user, UserUpdatorRequest $request)
    {
        try {
            $this->updaterService->update($user, $request->all());
            return response()->json(['message' => 'Usuário atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return reponse()->json(['error' => $e->getMessage()], 400);
        }
    }
}
