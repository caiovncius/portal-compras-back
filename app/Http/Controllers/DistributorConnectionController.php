<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\DistributorConnection;
use App\DistributorConnection\Contracts\DistributorConnectionCreatable;
use App\DistributorConnection\Contracts\DistributorConnectionUpdatable;
use App\Http\Requests\DistributorConnectionCreatorRequest;
use App\Http\Requests\DistributorConnectionUpdatorRequest;
use App\Http\Resources\DistributorConnectionListResource;
use Illuminate\Http\Request;

class DistributorConnectionController extends Controller
{

    /**
     * @var DistributorConnectionCreatable
     */
    private $creatorService;

    /**
     * @var DistributorConnectionUpdatable
     */
    private $updatorService;


    /**
     * DistributorConnectionController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->creatorService = app()->make(DistributorConnectionCreatable::class);
        $this->updatorService = app()->make(DistributorConnectionUpdatable::class);
    }


    /**
     *
     * @OA\Post(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/connection",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorConnectionCreatorRequest")
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
     *                     example ="Conexão criada com sucesso"
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
     * @param DistributorConnectionCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Distributor $distributor, DistributorConnectionCreatorRequest $request)
    {
        try {
            $this->creatorService->store($distributor, $request->all());
            return response()->json(['message' => 'Conexão criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/connection/{connection}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorConnectionUpdatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="distributor",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\Parameter(
     *        name="connection",
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
     * @param DistributorConnectionUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Distributor $distributor, DistributorConnectionUpdatorRequest $request, DistributorConnection $distributorConnection)
    {
        try {
            $this->updatorService->update($distributor, $distributorConnection, $request->all());
            return response()->json(['message' => 'Distribuidor atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
