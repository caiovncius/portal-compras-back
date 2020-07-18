<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaboratoryCreatorRequest;
use App\Http\Requests\LaboratoryUpdatorRequest;
use App\Http\Resources\LaboratoryListResource;
use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryCreatable;
use App\Laboratory\Contracts\LaboratoryUpdatable;
use App\Laboratory\Contracts\LaboratoryRemovable;
use App\Laboratory\Contracts\LaboratoryRetrievable;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    /**
     * @var LaboratoryCreatable
     */
    private $creatorService;

    /**
     * @var LaboratoryUpdatable
     */
    private $updaterService;

    /**
     * @var LaboratoryRemovable
     */
    private $removerService;

    /**
     * @var LaboratoryRetrievable
     */
    private $retreiverService;

    public function __construct()
    {
        $this->creatorService = app()->make(LaboratoryCreatable::class);
        $this->updaterService = app()->make(LaboratoryUpdatable::class);
        $this->removerService = app()->make(LaboratoryRemovable::class);
        $this->retreiverService = app()->make(LaboratoryRetrievable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Laboratories"},
     *     path="/laboratories",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="ACTIVE",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="Teste 01",
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
     *                     @OA\Items(ref="#/components/schemas/LaboratoryListResource"),
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
            return LaboratoryListResource::collection($this->retreiverService->laboratories($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Laboratories"},
     *     path="/laboratories/active",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="data", ref="#/components/schemas/LaboratoryListResource"),
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
     * @param $type
     * @return LaboratoryListResource
     */
    public function active()
    {
        return LaboratoryListResource::collection(Laboratory::active()->get());
    }

    /**
     *
     * @OA\GET(
     *     tags={"Laboratories"},
     *     path="/laboratories/{laboratory}",
     *     @OA\Parameter(
     *        name="laboratory",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/LaboratoryListResource"),
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
     * @param Laboratory $laboratory
     * @return LaboratoryResource
     */
    public function get(Laboratory $laboratory)
    {
        return LaboratoryListResource::make($laboratory);
    }

    /**
     *
     * @OA\Post(
     *     tags={"Laboratories"},
     *     path="/laboratories",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LaboratoryCreatorRequest")
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
     * @param LaboratoryCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LaboratoryCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Laboratório criado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }


    /**
     *
     * @OA\Put(
     *     tags={"Laboratories"},
     *     path="/laboratories/{laboratory}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LaboratoryUpdaterRequest")
     *      ),
     *     @OA\Parameter(
     *        name="Laboratory",
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
     *                     example ="Laboratório atualizado com sucesso"
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
     * @param LaboratoryCreatorRequest $request
     * @return mixed
     */
    public function update(Laboratory $laboratory, LaboratoryUpdatorRequest $request)
    {
        try {
            $this->updaterService->update($laboratory, $request->all());
            return response()->json(['message' => 'Laboratório atualizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Laboratories"},
     *     path="/laboratories/{laboratory}",
     *     @OA\Parameter(
     *        name="Laboratory",
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
     *                     example ="Laboratório removido com sucesso"
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
     * @param Laboratory $laboratory
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Laboratory $laboratory)
    {
        try {
            $this->removerService->delete($laboratory);
            return response()->json(['message' => 'Laboratório removido com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
