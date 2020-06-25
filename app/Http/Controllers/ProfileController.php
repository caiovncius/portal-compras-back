<?php

namespace App\Http\Controllers;

use App\Functionality;
use App\Http\Requests\ProfileCreatorRequest;
use App\Http\Requests\ProfileUpdatorRequest;
use App\Http\Resources\FunctionalityResource;
use App\Http\Resources\ProfileFunctionsResource;
use App\Http\Resources\ProfileListResource;
use App\Http\Resources\ProfileResource;
use App\Profile;
use App\Profile\Contracts\ProfileCreatable;
use App\Profile\Contracts\ProfileRemovable;
use App\Profile\Contracts\ProfileRetrievable;
use App\Profile\Contracts\ProfileUpdatable;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var ProfileRetrievable
     */
    private $retrieverService;

    /**
     * @var ProfileCreatable
     */
    private $creatorService;

    /**
     * @var ProfileUpdatable
     */
    private $updatorService;

    /**
     * @var ProfileRemovable
     */
    private $removerService;


    /**
     * ProfileController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(ProfileRetrievable::class);
        $this->creatorService = app()->make(ProfileCreatable::class);
        $this->updatorService = app()->make(ProfileUpdatable::class);
        $this->removerService = app()->make(ProfileRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Profiles"},
     *     path="/profiles",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="nome",
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
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ProfileListResource"),
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
    public function list(Request $request)
    {
        try {
            return ProfileListResource::collection($this->retrieverService->profiles($request->query())->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Profiles"},
     *     path="/profiles",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProfileCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Perfil criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="",
     *     @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     * ),
     * @OA\Response(
     *     response=400,
     *     description="",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             example ="Mensagem de erro"
     *         )
     *     )
     * )
     *
     * )
     */

    /**
     * @param ProfileCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProfileCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Perfil criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Profiles"},
     *     path="/profiles/{profile}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProfileUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="profile",
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
     *                     example ="Perfil atualizado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="",
     *     @OA\JsonContent(ref="#/components/schemas/ValidationResponse")
     * ),
     * @OA\Response(
     *     response=400,
     *     description="",
     *     @OA\JsonContent(
     *         @OA\Property(
     *             property="error",
     *             example ="Mensagem de erro"
     *         )
     *     )
     * )
     *
     * )
     */

    /**
     * @param ProfileUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileUpdatorRequest $request, Profile $profile)
    {
        try {
            $this->updatorService->update($profile, $request->all());
            return response()->json(['message' => 'Perfil atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Profiles"},
     *     path="/profiles/{profile}",
     *     @OA\Parameter(
     *        name="profile",
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
     *                     example ="Perfil removido com sucesso"
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
     * @param Profile $profile
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Profile $profile)
    {
        try {
            $this->removerService->delete($profile);
            return response()->json(['message' => 'Perfil removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Profiles"},
     *     path="/profiles/{profile}",
     *     @OA\Parameter(
     *        name="profile",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ProfileResource"),
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
     * @param Profile $profile
     * @return ProfileResource
     */
    public function get(Profile $profile)
    {
        return ProfileResource::make($profile);
    }

    /**
     *
     * @OA\GET(
     *     tags={"Functions"},
     *     path="/functions",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ProfileFunctionsResource"),
     *                 ),
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
     * @return ProfileFunctionsResource
     */
    public function functions()
    {
        return FunctionalityResource::collection(Functionality::all());
    }

    /**
     *
     * @OA\GET(
     *     tags={"Profiles"},
     *     path="/profiles/by-type/{type}",
     *     @OA\Parameter(
     *        name="type",
     *        in="path",
     *        example="PHARMACY",
     *        required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data", ref="#/components/schemas/ProfileListResource"),
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
     * @param $type
     * @return ProfileListResource
     */
    public function byType($type)
    {
        return ProfileListResource::collection(Profile::byType($type)->get());
    }
}
