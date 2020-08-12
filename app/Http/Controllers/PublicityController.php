<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicityUpdatorRequest;
use App\Publicity;
use App\Publicity\Contracts\PublicityUpdatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicityController extends Controller
{
    /**
     * @var PublicityUpdatable
     */
    private $updatorService;


    /**
     * PublicityController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->updatorService = app()->make(PublicityUpdatable::class);
    }

    /**
     *
     * @OA\Put(
     *     tags={"Publicities"},
     *     path="/publicities",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PublicityUpdatorRequest")
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
     *                     example ="Condição atualizada com sucesso"
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
     * @param PublicityUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PublicityUpdatorRequest $request)
    {
        try {
            $publicity = Publicity::find(1);

            $this->updatorService->update($publicity, $request->all());
            return response()->json(['message' => 'Condição atualizada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Publicities"},
     *     path="/publicities",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data", ref="#/components/schemas/PublicityListResource"),
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
     * @return PublicityListResource
     */
    public function get()
    {
        $publicity = Publicity::find(1);

        return PublicityListResource::make($publicity);
    }
}
