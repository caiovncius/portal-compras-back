<?php

namespace App\Http\Controllers;

use App\Http\Requests\SecondaryEanCodeRequest;
use App\Product;
use App\SecondaryEacCode\Contracts\SecondaryEanCodeRemovable;
use App\SecondaryEacCode\Contracts\SecondaryEanCodeCreatorable;
use App\SecondaryEanCode;
use Illuminate\Http\Request;

class SecondaryEanCodeController extends Controller
{
    /**
     * @var SecondaryEanCodeCreatorable
     */
    private $updaterService;

    /**
     * @var SecondaryEanCodeRemovable
     */
    private $removerService;

    public function __construct()
    {
        $this->updaterService = app()->make(SecondaryEanCodeCreatorable::class);
        $this->removerService = app()->make(SecondaryEanCodeRemovable::class);
    }

    /**
     *
     * @OA\Post(
     *     tags={"SecondaryEanCode"},
     *     path="/products/{product}/add-secondary-ean-code",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SecondaryEanCodeCreatorRequest")
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
     *                     example ="Código EAN secundário criado com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param SecondaryEanCodeRequest $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SecondaryEanCodeRequest $request, Product $product)
    {
        try {
            $this->updaterService->create($product, $request->all());
            return response()->json(['message' => 'Código EAN secundário adicionado com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"SecondaryEanCode"},
     *     path="/secondary-ean-code/{secondaryEanCode}",
     *     @OA\Parameter(
     *        name="secondaryEanCode",
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
     * @param SecondaryEanCode $secondaryEanCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(SecondaryEanCode $secondaryEanCode)
    {
        try {
            $this->removerService->remove($secondaryEanCode);
            return response()->json(['message' => 'Código EAN secundário removido com sucesso!'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
