<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\PurchaseListResource;
use App\Product\Contracts\ProductDetailRetrievable;
use App\Purchase;
use App\Purchase\Contracts\PurchaseCreatable;
use App\Purchase\Contracts\PurchaseRemovable;
use App\Purchase\Contracts\PurchaseRetrievable;
use App\Purchase\Contracts\PurchaseUpdatable;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * @var PurchaseRetrievable
     */
    private $retrieverService;

    /**
     * @var ProductDetailRetrievable
     */
    private $productRetrieverService;

    /**
     * @var PurchaseCreatable
     */
    private $creatorService;

    /**
     * @var PurchaseUpdatable
     */
    private $updatorService;

    /**
     * @var PurchaseRemovable
     */
    private $removerService;


    /**
     * PurchaseController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(PurchaseRetrievable::class);
        $this->productRetrieverService = app()->make(ProductDetailRetrievable::class);
        $this->creatorService = app()->make(PurchaseCreatable::class);
        $this->updatorService = app()->make(PurchaseUpdatable::class);
        $this->removerService = app()->make(PurchaseRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Purchases"},
     *     path="/purchases",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Parameter(
     *        name="validityStart",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="validityEnd",
     *        in="query",
     *        example="2020-06-25",
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
     *                     @OA\Items(ref="#/components/schemas/PurchaseListResource"),
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
            return PurchaseListResource::collection($this->retrieverService->getPurchases($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Purchases"},
     *     path="/purchases/portal",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Parameter(
     *        name="validityStart",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="validityEnd",
     *        in="query",
     *        example="2020-06-25",
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
     *                     @OA\Items(ref="#/components/schemas/PurchaseListResource"),
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
    public function portal(Request $request)
    {
        try {
            return PurchaseListResource::collection($this->retrieverService->getPurchases($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Purchases"},
     *     path="/purchases/{id}/products",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
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
     *                     @OA\Items(ref="#/components/schemas/ProductDetailResource"),
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @param Purchase $model
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function products(Purchase $model, Request $request)
    {
        try {
            return ProductDetailResource::collection($this->productRetrieverService->getProducts($model, $request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Purchases"},
     *     path="/purchases",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PurchaseRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Compra criada com sucesso"
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
     * @param PurchaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PurchaseRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Compra criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Purchases"},
     *     path="/purchases/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PurchaseRequest")
     *      ),
     *     @OA\Parameter(
     *        name="id",
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
     *                     example ="Compra atualizada com sucesso"
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
     * @param PurchaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PurchaseRequest $request, Purchase $model)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Compra atualizada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Purchases"},
     *     path="/purchases/{id}",
     *     @OA\Parameter(
     *        name="id",
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
     *                     example ="Compra removida com sucesso"
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
     * @param Purchase $Purchase
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Purchase $Purchase)
    {
        try {
            $this->removerService->delete($Purchase);
            return response()->json(['message' => 'Compra removida com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Purchases"},
     *     path="/purchases/{id}",
     *     @OA\Parameter(
     *        name="id",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/PurchaseListResource"),
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
     * @param Purchase $model
     * @return PurchaseListResource
     */
    public function get(Purchase $model)
    {
        return PurchaseListResource::make($model);
    }

}
