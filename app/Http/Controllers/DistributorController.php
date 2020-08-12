<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistributorCreatorRequest;
use App\Http\Requests\DistributorUpdatorRequest;
use App\Http\Resources\DistributorListResource;
use App\Http\Resources\DistributorResource;
use App\Distributor;
use App\Distributor\Contracts\DistributorCreatable;
use App\Distributor\Contracts\DistributorRetrievable;
use App\Distributor\Contracts\DistributorUpdatable;
use App\Distributor\Contracts\DistributorRemovable;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * @var DistributorRetrievable
     */
    private $retrieverService;

    /**
     * @var DistributorCreatable
     */
    private $creatorService;

    /**
     * @var DistributorUpdatable
     */
    private $updatorService;

    /**
     * @var DistributorRemovable
     */
    private $removerService;


    /**
     * DistributorController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(DistributorRetrievable::class);
        $this->creatorService = app()->make(DistributorCreatable::class);
        $this->updatorService = app()->make(DistributorUpdatable::class);
        $this->removerService = app()->make(DistributorRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Distributors"},
     *     path="/distributors",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="00.0001/00001-14",
     *     ),
     *     @OA\Parameter(
     *        name="cnpj",
     *        in="query",
     *        example="00.0001/00001-14",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="ACTIVE",
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
     *                     @OA\Items(ref="#/components/schemas/DistributorListResource"),
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
            return DistributorListResource::collection($this->retrieverService->getDistributors($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Distributors"},
     *     path="/distributors/all",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/DistributorListResource"),
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
    public function all(Request $request)
    {
        try {
            return DistributorListResource::collection($this->retrieverService->getDistributors($request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Distributors"},
     *     path="/distributors",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distribuidor criado com sucesso"
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
     * @param DistributorCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DistributorCreatorRequest $request)
    {
        try {
            $data = $this->creatorService->store($request->all());
            return response()->json(['message' => 'Distribuidor criado com sucesso', 'data' => $data], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="distributor",
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
     *                     example ="Distribuidor atualizado com sucesso"
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
     * @param DistributorUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DistributorUpdatorRequest $request, Distributor $distributor)
    {
        try {
            $this->updatorService->update($distributor, $request->all());
            return response()->json(['message' => 'Distribuidor atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}",
     *     @OA\Parameter(
     *        name="distributor",
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
     *                     example ="Distribuidor removido com sucesso"
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
     * @param Distributor $distributor
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Distributor $distributor)
    {
        try {
            $this->removerService->delete($distributor);
            return response()->json(['message' => 'Distribuidor removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}",
     *     @OA\Parameter(
     *        name="distributor",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/DistributorResource"),
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
     * @param Distributor $distributor
     * @return DistributorResource
     */
    public function get(Distributor $distributor)
    {
        return DistributorResource::make($distributor);
    }

}
