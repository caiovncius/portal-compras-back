<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferCreatorRequest;
use App\Http\Requests\OfferUpdatorRequest;
use App\Http\Resources\OfferListResource;
use App\Offer;
use App\Offer\Contracts\OfferCreatable;
use App\Offer\Contracts\OfferRetrievable;
use App\Offer\Contracts\OfferUpdatable;
use App\Offer\Contracts\OfferRemovable;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * @var OfferRetrievable
     */
    private $retrieverService;

    /**
     * @var OfferCreatable
     */
    private $creatorService;

    /**
     * @var OfferUpdatable
     */
    private $updatorService;

    /**
     * @var OfferRemovable
     */
    private $removerService;


    /**
     * OfferController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(OfferRetrievable::class);
        $this->creatorService = app()->make(OfferCreatable::class);
        $this->updatorService = app()->make(OfferUpdatable::class);
        $this->removerService = app()->make(OfferRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Offers"},
     *     path="/offers",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="123",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Parameter(
     *        name="startDate",
     *        in="query",
     *        example="2020-05-25 03:00:00",
     *     ),
     *     @OA\Parameter(
     *        name="endDate",
     *        in="query",
     *        example="2020-06-25 03:00:00",
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
     *                     @OA\Items(ref="#/components/schemas/OfferListResource"),
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
            return OfferListResource::collection($this->retrieverService->getOffers($request->query())->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Offers"},
     *     path="/offers",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OfferCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Offera criado com sucesso"
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
     * @param OfferCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OfferCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Offera criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Offers"},
     *     path="/offers/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/OfferUpdatorRequest")
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
     *                     example ="Offera atualizado com sucesso"
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
     * @param OfferUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OfferUpdatorRequest $request, Offer $model)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Offera atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Offers"},
     *     path="/offers/{id}",
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
     *                     example ="Offera removido com sucesso"
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
     * @param Offer $Offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Offer $Offer)
    {
        try {
            $this->removerService->delete($Offer);
            return response()->json(['message' => 'Offera removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Offers"},
     *     path="/offers/{id}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/OfferListResource"),
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
     * @param Offer $model
     * @return OfferListResource
     */
    public function get(Offer $model)
    {
        return OfferListResource::make($model);
    }

}