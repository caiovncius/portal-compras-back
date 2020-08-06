<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferProductRequest;
use App\Offer;
use App\Offer\Contracts\OfferProductCreatable;
use Illuminate\Http\Request;

class OfferProductController extends Controller
{

    /**
     * @var OfferProductCreatable
     */
    private $creatorService;

    public function __construct()
    {
        $this->creatorService = app()->make(OfferProductCreatable::class);
    }


    /**
     *
     * @OA\Post(
     *     tags={"Offers"},
     *     path="/offer-products/{offer}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OfferProductRequest")
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
    public function store(Offer $offer, OfferProductRequest $request)
    {
        try {
            $this->creatorService->store($offer, $request->all());
            return response()->json(['message' => 'Produtos criados com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
