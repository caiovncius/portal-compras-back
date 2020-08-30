<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDetailRequest;
use App\Offer;
use App\Product\Contracts\ProductDetailCreatable;
use App\Purchase;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{

    /**
     * @var ProductDetailCreatable
     */
    private $creatorService;

    public function __construct()
    {
        $this->creatorService = app()->make(ProductDetailCreatable::class);
    }


    /**
     *
     * @OA\Post(
     *     tags={"Offers"},
     *     path="/offer-products/{offer}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductDetailRequest")
     *      ),
     *     @OA\Parameter(
     *        name="offer",
     *        in="path",
     *        example="1",
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
     *                     example ="Produtos criados com sucesso"
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
     * @param ConnectionCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function offer(Offer $offer, ProductDetailRequest $request)
    {
        try {
            $this->creatorService->store($offer, $request->all());
            return response()->json(['message' => 'Produtos criados com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }


    /**
     *
     * @OA\Post(
     *     tags={"Purchases"},
     *     path="/purchase-products/{purchase}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProductDetailRequest")
     *      ),
     *     @OA\Parameter(
     *        name="purchase",
     *        in="path",
     *        example="1",
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
     *                     example ="Produtos criados com sucesso"
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
     * @param ConnectionCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(Purchase $purchase, ProductDetailRequest $request)
    {
        try {
            $this->creatorService->store($purchase, $request->all());
            return response()->json(['message' => 'Produtos criados com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
