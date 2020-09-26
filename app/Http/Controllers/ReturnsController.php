<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnCreatorRequest;
use App\Http\Requests\ReturnUpdatorRequest;
use App\Http\Resources\ReturnListResource;
use App\Returns;
use App\Returns\Contracts\ReturnsCreatable;
use App\Returns\Contracts\ReturnsRetrievable;
use App\Returns\Contracts\ReturnsUpdatable;
use App\Returns\Contracts\ReturnsRemovable;
use Illuminate\Http\Request;

class ReturnsController extends Controller
{
    /**
     * @var ReturnsRetrievable
     */
    private $retrieverService;

    /**
     * @var ReturnsCreatable
     */
    private $creatorService;

    /**
     * @var ReturnsUpdatable
     */
    private $updatorService;

    /**
     * @var ReturnsRemovable
     */
    private $removerService;


    /**
     * ReturnsController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(ReturnsRetrievable::class);
        $this->creatorService = app()->make(ReturnsCreatable::class);
        $this->updatorService = app()->make(ReturnsUpdatable::class);
        $this->removerService = app()->make(ReturnsRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Returns"},
     *     path="/returns",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="desc",
     *        in="query",
     *        example="Teste",
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
     *                     @OA\Items(ref="#/components/schemas/ReturnListResource"),
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
            return ReturnListResource::collection($this->retrieverService->getReturns($request->query())->paginate(2));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Returns"},
     *     path="/returns/all",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ReturnListResource"),
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
    public function all(Request $request)
    {
        try {
            $input['status'] = 'ACTIVE';
            $input['global'] = true;
            return ReturnListResource::collection($this->retrieverService->getReturns($input)->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Returns"},
     *     path="/returns",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ReturnCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Retorno criado com sucesso"
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
     * @param ReturnCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReturnCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Retorno criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Returns"},
     *     path="/returns/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ReturnUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="Returns",
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
     *                     example ="Retorno atualizado com sucesso"
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
     * @param ReturnUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ReturnUpdatorRequest $request, Returns $returns)
    {
        try {
            $this->updatorService->update($returns, $request->all());
            return response()->json(['message' => 'Retorno atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Returns"},
     *     path="/returns/{id}",
     *     @OA\Parameter(
     *        name="Returns",
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
     *                     example ="Retorno removido com sucesso"
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
     * @param Returns $returns
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Returns $return)
    {
        try {
            $this->removerService->delete($return);
            return response()->json(['message' => 'Retorno removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Returns"},
     *     path="/returns/{id}",
     *     @OA\Parameter(
     *        name="Returns",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ReturnListResource"),
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
     * @param Returns $returns
     * @return ReturnListResource
     */
    public function get(Returns $returns)
    {
        return ReturnListResource::make($returns);
    }

}
