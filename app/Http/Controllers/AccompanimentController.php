<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccompanimentCreatorRequest;
use App\Http\Requests\AccompanimentUpdatorRequest;
use App\Http\Resources\AccompanimentListResource;
use App\Accompaniment;
use App\Accompaniment\Contracts\AccompanimentCreatable;
use App\Accompaniment\Contracts\AccompanimentRetrievable;
use App\Accompaniment\Contracts\AccompanimentUpdatable;
use App\Accompaniment\Contracts\AccompanimentRemovable;
use Illuminate\Http\Request;

class AccompanimentController extends Controller
{
    /**
     * @var AccompanimentRetrievable
     */
    private $retrieverService;

    /**
     * @var AccompanimentCreatable
     */
    private $creatorService;

    /**
     * @var AccompanimentUpdatable
     */
    private $updatorService;

    /**
     * @var AccompanimentRemovable
     */
    private $removerService;


    /**
     * AccompanimentController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(AccompanimentRetrievable::class);
        $this->creatorService = app()->make(AccompanimentCreatable::class);
        $this->updatorService = app()->make(AccompanimentUpdatable::class);
        $this->removerService = app()->make(AccompanimentRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Accompaniments"},
     *     path="/accompaniments",
     *     @OA\Parameter(
     *        name="codeOrder",
     *        in="query",
     *        example="001",
     *     ),
     *     @OA\Parameter(
     *        name="codeOffer",
     *        in="query",
     *        example="321",
     *     ),
     *     @OA\Parameter(
     *        name="codePharmacy",
     *        in="query",
     *        example="321",
     *     ),
     *     @OA\Parameter(
     *        name="startDate",
     *        in="query",
     *        example="1992-10-11",
     *     ),
     *     @OA\Parameter(
     *        name="endDate",
     *        in="query",
     *        example="1992-10-11",
     *     ),
     *     @OA\Parameter(
     *        name="commercial",
     *        in="query",
     *        example="Teste",
     *     ),
     *     @OA\Parameter(
     *        name="sendType",
     *        in="query",
     *        example="TESTE",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="Ativo",
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
     *                     @OA\Items(ref="#/components/schemas/AccompanimentListResource"),
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
            return AccompanimentListResource::collection($this->retrieverService->getAccompaniments($request->query())->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Accompaniments"},
     *     path="/accompaniments",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AccompanimentCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Acompanhamento criado com sucesso"
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
     * @param AccompanimentCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AccompanimentCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all);
            return response()->json(['message' => 'Acompanhamento criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Accompaniments"},
     *     path="/accompaniments/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AccompanimentUpdatorRequest")
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
     *                     example ="Acompanhamento atualizado com sucesso"
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
     * @param AccompanimentUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccompanimentUpdatorRequest $request, Accompaniment $model)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Acompanhamento atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Accompaniments"},
     *     path="/accompaniments/{id}",
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
     *                     example ="Acompanhamento removido com sucesso"
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
     * @param Accompaniment $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Accompaniment $model)
    {
        try {
            $this->removerService->delete($model);
            return response()->json(['message' => 'Acompanhamento removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Accompaniments"},
     *     path="/accompaniments/{id}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/AccompanimentListResource"),
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
     * @param Accompaniment $model
     * @return AccompanimentListResource
     */
    public function get(Accompaniment $model)
    {
        return AccompanimentListResource::make($model);
    }

}
