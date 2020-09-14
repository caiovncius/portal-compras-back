<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriorityRequest;
use App\Http\Resources\DistributorListResource;
use App\Http\Resources\PriorityAutoCompleteResource;
use App\Http\Resources\PriorityListResource;
use App\Http\Resources\PriorityResource;
use App\Priority;
use App\Priority\Contracts\PriorityCreatable;
use App\Priority\Contracts\PriorityRemovable;
use App\Priority\Contracts\PriorityRetrievable;
use App\Priority\Contracts\PriorityUpdatable;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    /**
     * @var PriorityCreatable
     */
    private $creatorService;

    /**
     * @var PriorityUpdatable
     */
    private $updaterService;

    /**
     * @var PriorityRemovable
     */
    private $removerService;

    /**
     * @var PriorityRetrievable
     */
    private $retrieverService;

    public function __construct()
    {
        $this->creatorService = app()->make(PriorityCreatable::class);
        $this->updaterService = app()->make(PriorityUpdatable::class);
        $this->removerService = app()->make(PriorityRemovable::class);
        $this->retrieverService = app()->make(PriorityRetrievable::class);
    }

    /**
     *
     * @OA\Post(
     *     tags={"Priority"},
     *     path="/priorities",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PriorityRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Prioridade criada com sucesso"
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
     * @param PriorityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PriorityRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Prioridade criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Priority"},
     *     path="/priorities/{$priority}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PriorityRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Prioridade criada com sucesso"
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
     * @param PriorityRequest $request
     * @param \App\Priority $priority
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PriorityRequest $request, \App\Priority $priority)
    {
        try {
            $this->updaterService->update($priority, $request->all());
            return response()->json(['message' => 'Prioridade editada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Priority"},
     *     path="/priorities/{$priority}",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Prioridade criada com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  example ="Mensagem de erro"
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param \App\Priority $priority
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(\App\Priority $priority)
    {
        try {
            $this->removerService->delete($priority);
            return response()->json(['message' => 'Prioridade removida com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Priority"},
     *     path="/priorities/{priority}",
     *     @OA\Parameter(
     *        name="priority",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/PriorityResource"),
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
     * @param Priority $priority
     * @return PriorityResource|\Illuminate\Http\JsonResponse
     */
    public function get(Priority $priority)
    {
        try {
            return PriorityResource::make($priority);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Priority"},
     *     path="/priorities",
     *     @OA\Parameter(
     *        name="id",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="description",
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
     *                     @OA\Items(ref="#/components/schemas/PriorityListResource"),
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
            return PriorityListResource::collection($this->retrieverService->getPriorities($request->query())->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }


    /**
     * @OA\Get(
     *     tags={"Priority"},
     *     path="/priorities/national-partners",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/DistributorListResource"),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function listNationalPartners()
    {
        try {
            return DistributorListResource::collection($this->retrieverService->getNationalPartners()->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Priority"},
     *     path="/priorities/regional-partners",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/DistributorListResource"),
     *                 ),
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function listRegionalPartners()
    {
        try {
            return DistributorListResource::collection($this->retrieverService->getRegionalPartners()->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Priority"},
     *     path="/priorities/search",
     *     @OA\Parameter(
     *        name="id",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="description",
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
     *                     @OA\Items(ref="#/components/schemas/PriorityListResource"),
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
    public function search(Request $request)
    {
        try {
            return PriorityAutoCompleteResource::collection($this->retrieverService->getPriorities($request->all())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
