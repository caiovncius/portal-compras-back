<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreatorRequest;
use App\Http\Requests\UserUpdatorRequest;
use App\Http\Resources\PharmacyResource;
use App\Http\Resources\UserListResource;
use App\Http\Resources\UserResource;
use App\Notifications\PasswordReseted;
use App\User;
use App\User\Contracts\UserCreatable;
use App\User\Contracts\UserRemovable;
use App\User\Contracts\UserRetrievable;
use App\User\Contracts\UserUpdatable;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserCreatable
     */
    private $creatorService;

    /**
     * @var UserUpdatable
     */
    private $updaterService;

    /**
     * @var UserRemovable
     */
    private $removerService;

    /**
     * @var UserRetrievable
     */
    private $retreiverService;

    public function __construct()
    {
        $this->creatorService = app()->make(UserCreatable::class);
        $this->updaterService = app()->make(UserUpdatable::class);
        $this->removerService = app()->make(UserRemovable::class);
        $this->retreiverService = app()->make(UserRetrievable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="nome",
     *     ),
     *     @OA\Parameter(
     *        name="email",
     *        in="query",
     *        example="email@email.com",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="ACTIVE",
     *     ),
     *     @OA\Parameter(
     *        name="type",
     *        in="query",
     *        example="COMMERCIAL",
     *     ),
     *     @OA\Parameter(
     *        name="createdAt",
     *        in="query",
     *        example="2020-01-01",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/UserListResource"),
     *                 ),
     *                 @OA\Property(
     *                     property="links",
     *                     allOf={
     *                         @OA\Items(ref="#/components/schemas/PaginationLinks"),
     *                     }
     *                 ),
     *                  @OA\Property(
     *                     property="meta",
     *                     allOf={
     *                         @OA\Items(ref="#/components/schemas/PaginationMeta"),
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request) {
        try {
            return UserListResource::collection($this->retreiverService->getUsers($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users/managers",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="nome",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/UserListResource"),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function managers(Request $request) {
        try {
            return UserListResource::collection($this->retreiverService->getUsers($request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Users"},
     *     path="/users/{user}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/UserResource"),
     *             )
     *         )
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
     * @param User $user
     * @return UserResource
     */
    public function get(User $user)
    {
        return UserResource::make($user);
    }

    /**
     *
     * @OA\GET(
     *     tags={"Users"},
     *     path="/users/{user}/pharmacies",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/PharmacyResource"),
     *             )
     *         )
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
     * @param User $user
     * @return PharmacyResource
     */
    public function pharmacies(User $user)
    {
        $data = $user->pharmacies()->active()->paginate(10);
        
        return PharmacyResource::collection($data);
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users/{user}/pharmacies/all",
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
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/PharmacyResource"),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function pharmaciesAll(User $user)
    {        
        try {
            $data = $user->pharmacies()->active()->get();
            
            return PharmacyResource::collection($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\POST(
     *     tags={"Users"},
     *     path="/users/password",
     *     @OA\Parameter(
     *        name="email",
     *        in="path",
     *        example="teste@domain.com",
     *        required=false
     *     ),
     *     @OA\Parameter(
     *        name="username",
     *        in="path",
     *        example="teste",
     *        required=false
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data", ref="#/components/schemas/UserListResource"),
     *             )
     *         )
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function password(Request $request)
    {
        try {
            $user = $this->retreiverService->getUsers($request->query())
                                           ->first();
            if (!$user) {
                return response()->json(['error' => 'Usuário não existe'], 400);
            }

            $password = 'N3WP$SS123';
            $user->password = bcrypt($password);
            $user->save();

            $user->notify(new PasswordReseted($password));

            return response()->json(['message' => 'Usuário criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }

        return UserListResource::make($user);
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
     *
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
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Users"},
     *     path="/users/{user}",
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
     *                     example ="Usuário removido com sucesso"
     *                 )
     *             )
     *         )
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
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user)
    {
        try {
            $this->removerService->delete($user);
            return response()->json(['message' => 'Usuário removido com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
