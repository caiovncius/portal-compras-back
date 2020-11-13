<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreatorRequest;
use App\Http\Requests\ProductMassCreateRequest;
use App\Http\Requests\ProductMassUpdateRequest;
use App\Http\Requests\ProductUpdatorRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Product\Contracts\ProductCreatable;
use App\Product\Contracts\ProductUpdatable;
use App\Product\Contracts\ProductRemovable;
use App\Product\Contracts\ProductRetrievable;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductCreatable
     */
    private $creatorService;

    /**
     * @var ProductUpdatable
     */
    private $updaterService;

    /**
     * @var ProductRemovable
     */
    private $removerService;

    /**
     * @var ProductRetrievable
     */
    private $retreiverService;

    public function __construct()
    {
        $this->creatorService = app()->make(ProductCreatable::class);
        $this->updaterService = app()->make(ProductUpdatable::class);
        $this->removerService = app()->make(ProductRemovable::class);
        $this->retreiverService = app()->make(ProductRetrievable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/products",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="codeEan",
     *        in="query",
     *        example="02",
     *     ),
     *     @OA\Parameter(
     *        name="description",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="ACTIVE",
     *     ),
     *     @OA\Parameter(
     *        name="laboratoryId",
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
     *                     @OA\Items(ref="#/components/schemas/ProductListResource"),
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
            return ProductListResource::collection($this->retreiverService->getProducts($request->query())->paginate(10));
        } catch (\Exception $exception) {
            dd($exception);
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Products"},
     *     path="/products/all",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/ProductListResource"),
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
    public function all(Request $request) {
        try {
            return ProductListResource::collection($this->retreiverService->getProducts($request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Products"},
     *     path="/products",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Produto criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProductCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Produto criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }


    /**
     *
     * @OA\GET(
     *     tags={"Products"},
     *     path="/products/{product}",
     *     @OA\Parameter(
     *        name="product",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ProductListResource"),
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
     * @param Product $product
     * @return ProductListResource
     */
    public function get(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     *
     * @OA\Put(
     *     tags={"Products"},
     *     path="/products/{product}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductUpdaterRequest")
     *      ),
     *     @OA\Parameter(
     *        name="product",
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
     *                     example ="Produto atualizado com sucesso"
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
     * @param ProductCreatorRequest $request
     * @return mixed
     */
    public function update(Product $product, ProductUpdatorRequest $request)
    {
        try {
            $this->updaterService->update($product, $request->all());
            return response()->json(['message' => 'Produto atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Products"},
     *     path="/products/{product}",
     *     @OA\Parameter(
     *        name="product",
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
     *                     example ="Produto removido com sucesso"
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
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Product $product)
    {
        try {
            $this->removerService->delete($product);
            return response()->json(['message' => 'Produto removido com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"ProductMassActions"},
     *     path="/mass-actions/products/create",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Laboratório criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProductMassCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massStore(ProductMassCreateRequest $request)
    {

        $errors = [];
        $lines = 0;

        foreach ($request->data as $product) {

            $lines++;

            try {

                if (!isset($product['code']) || empty($product['code'])) {
                    $errors[] = [
                        'message' => 'code is required',
                        'data' => null
                    ];
                    continue;
                }

                $localData = Product::where('code', $product['code'])->first();

                if (!is_null($localData)) {
                    $errors[] = [
                        'message' => 'code already in use',
                        'data' => $product['code']
                    ];

                    continue;
                }

                $this->creatorService->store($product);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $product
                ];
            }
        }

        return response()->json([
            'totalProcessed' => $lines,
            'successfully' => $lines - count($errors),
            'errors' => $errors
        ], 200);
    }

    /**
     *
     * @OA\Put(
     *     tags={"ProductMassActions"},
     *     path="/mass-actions/products/update",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Laboratório criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProductMassUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massUpdate(ProductMassUpdateRequest $request)
    {

        $errors = [];
        $lines = 0;

        foreach ($request->data as $product) {

            $lines++;

            try {

                if (!isset($product['code']) || empty($product['code'])) {
                    $errors[] = [
                        'message' => 'code is required',
                        'data' => null
                    ];
                    continue;
                }

                $localData = Product::where('code', $product['code'])->first();

                if (is_null($localData)) {
                    $errors[] = [
                        'message' => 'Entity not found',
                        'data' => $product['code']
                    ];

                    continue;
                }

                $this->updaterService->update($localData, $product);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $product
                ];
            }
        }

        return response()->json([
            'totalProcessed' => $lines,
            'successfully' => $lines - count($errors),
            'errors' => $errors
        ], 200);
    }

    /**
     *
     * @OA\Delete(
     *     tags={"ProductMassActions"},
     *     path="/mass-actions/products/delete",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Laboratório criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param ProductMassCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDelete(ProductMassCreateRequest $request)
    {
        $errors = [];
        $lines = 0;

        foreach ($request->data as $product) {

            $lines++;

            try {

                if (!isset($product['code']) || empty($product['code'])) {
                    $errors[] = [
                        'message' => 'code is required',
                        'data' => null
                    ];
                    continue;
                }

                $localData = Product::where('code', $product['code'])->first();

                if (is_null($localData)) {
                    $errors[] = [
                        'message' => 'Entity not found',
                        'data' => $product['code']
                    ];

                    continue;
                }

                $this->removerService->delete($localData);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $product
                ];
            }
        }

        return response()->json([
            'totalProcessed' => $lines,
            'successfully' => $lines - count($errors),
            'errors' => $errors
        ], 200);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Product $product)
    {
        $this->updaterService->enable($product);
        return response()->json(['message' => 'Produto ativada com sucesso']);
    }
}
