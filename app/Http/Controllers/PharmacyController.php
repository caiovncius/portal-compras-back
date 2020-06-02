<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyCreatorRequest;
use App\Http\Requests\PharmacyUpdatorRequest;
use App\Http\Resources\PharmacyListResource;
use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyCreatable;
use App\Pharmacy\Contracts\PharmacyUpdatable;
use App\Pharmacy\Contracts\PharmacyRemovable;
use App\Pharmacy\Contracts\PharmacyRetrievable;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * @var PharmacyCreatable
     */
    private $creatorService;

    /**
     * @var PharmacyUpdatable
     */
    private $updaterService;

    /**
     * @var PharmacyRemovable
     */
    private $removerService;

    /**
     * @var PharmacyRetrievable
     */
    private $retreiverService;

    public function __construct()
    {
        $this->creatorService = app()->make(PharmacyCreatable::class);
        $this->updaterService = app()->make(PharmacyUpdatable::class);
        $this->removerService = app()->make(PharmacyRemovable::class);
        $this->retreiverService = app()->make(PharmacyRetrievable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Pharmacies"},
     *     path="/pharmacies",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="cnpj",
     *        in="query",
     *        example="99.999.999/0001-91",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="ACTIVE",
     *     ),
     *     @OA\Parameter(
     *        name="city_id",
     *        in="query",
     *        example="02",
     *     ),
     *     @OA\Parameter(
     *        name="commercial",
     *        in="query",
     *        example="Teste 03",
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
     *                     @OA\Items(ref="#/components/schemas/PharmacyListResource"),
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
            return PharmacyListResource::collection($this->retreiverService->getPharmacies($request->query())->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Pharmacies"},
     *     path="/pharmacies",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PharmacyCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Farmácia criada com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param PharmacyCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PharmacyCreatorRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Farmácia criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }


    /**
     *
     * @OA\Put(
     *     tags={"Pharmacies"},
     *     path="/pharmacies/{pharmacy}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PharmacyUpdaterRequest")
     *      ),
     *     @OA\Parameter(
     *        name="pharmacy",
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
     *                     example ="Farmácia atualizada com sucesso"
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
     * @param PharmacyCreatorRequest $request
     * @return mixed
     */
    public function update(Pharmacy $pharmacy, PharmacyUpdatorRequest $request)
    {
        try {
            $this->updaterService->update($pharmacy, $request->all());
            return response()->json(['message' => 'Farmácia atualizada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Pharmacies"},
     *     path="/pharmacies/{pharmacy}",
     *     @OA\Parameter(
     *        name="pharmacy",
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
     *                     example ="Farmácia removida com sucesso"
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
     * @param Pharmacy $pharmacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Pharmacy $pharmacy)
    {
        try {
            $this->removerService->delete($pharmacy);
            return response()->json(['message' => 'Farmácia removida com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
