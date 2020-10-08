<?php

namespace App\Http\Controllers;

use App\Exports\PharmacyExport;
use App\Http\Requests\ContactCreatorRequest;
use App\Http\Requests\PharmacyCreatorRequest;
use App\Http\Requests\PharmacyMassCreateRequest;
use App\Http\Requests\PharmacyMassUpdatorRequest;
use App\Http\Requests\PharmacyUpdatorRequest;
use App\Http\Resources\PharmacyListResource;
use App\Http\Resources\PharmacyResource;
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
     *        name="socialName",
     *        in="query",
     *        example="teste",
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
     *        name="city",
     *        in="query",
     *        example="02",
     *     ),
     *     @OA\Parameter(
     *        name="state",
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
            return PharmacyListResource::collection($this->retreiverService->pharmacies($request->query())->paginate(10));
        } catch (\Exception $exception) {
            dd($exception);
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
     * @OA\GET(
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
     *                 @OA\Property(property="data", ref="#/components/schemas/PharmacyResource"),
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
     * @return PharmacyResource
     */
    public function get(Pharmacy $pharmacy)
    {
        return PharmacyResource::make($pharmacy);
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

    /**
     *
     * @OA\Post(
     *     tags={"Pharmacies"},
     *     path="/pharmacies/{pharmacy}/add-contact",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ContactCreatorRequest")
     *      ),
     *     @OA\Parameter(
     *        name="Pharmacy",
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
     *                     example ="Contato adicionado com sucesso"
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
     *                 example ="Mensagem de erro"
     *            )
     *         )
     *     )
     * )
     */

    /**
     * @param ContactCreatorRequest $request
     * @param Pharmacy $pharmacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function addContact(ContactCreatorRequest $request, Pharmacy $pharmacy)
    {
        try {
            $this->updaterService->addContact($pharmacy, $request->all());
            return response()->json(['message' => 'Contato adicionado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"PharmaciesMassActions"},
     *     path="/mass-actions/pharmacies/create",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PharmacyMassCreatorRequest")
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
     * @param PharmacyMassCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massStore(PharmacyMassCreateRequest $request)
    {
        $errors = [];
        $lines = 0;

        foreach ($request->data as $pharmacy) {

            $lines++;

            try {

                $this->creatorService->store($pharmacy);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $pharmacy
                ];
            }
        }

        return response()->json([
            'totalProcessed' => $lines,
            'successfully' => $lines - count($errors),
            'errors' => $errors
        ], 200);
    }

    /**
     *
     * @OA\Put(
     *     tags={"PharmaciesMassActions"},
     *     path="/mass-actions/pharmacies/update",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PharmacyMassCreatorRequest")
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
     * @param PharmacyMassUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massUpdate(PharmacyMassUpdatorRequest $request)
    {
        $errors = [];
        $lines = 0;

        foreach ($request->data as $pharmacy) {

            $lines++;

            try {

                $localData = Pharmacy::where('code', $pharmacy['code'])->first();

                if (is_null($localData)) {

                    $errors[] = [
                        'message' => 'Entity not found',
                        'data' => $pharmacy['code']
                    ];

                    continue;
                }

                $this->updaterService->update($localData, $pharmacy);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $pharmacy
                ];
            }
        }

        return response()->json([
            'totalProcessed' => $lines,
            'successfully' => $lines - count($errors),
            'errors' => $errors
        ], 200);
    }

    /**
     *
     * @OA\Delete(
     *     tags={"PharmaciesMassActions"},
     *     path="/mass-actions/pharmacies/delete",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PharmacyMassCreatorRequest")
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
     * @param LaboratoryMassCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDelete(PharmacyMassCreateRequest $request)
    {
        $errors = [];
        $lines = 0;

        foreach ($request->data as $pharmacy) {

            $lines++;

            try {

                $localData = Laboratory::where('code', $pharmacy['code'])->first();

                if (is_null($localData)) {
                    $errors[] = [
                        'message' => 'Entity not found',
                        'data' => $pharmacy['code']
                    ];

                    continue;
                }

                $this->removerService->delete($localData);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $pharmacy
                ];
            }
        }

        return response()->json([
            'totalProcessed' => $lines,
            'successfully' => $lines - count($errors),
            'errors' => $errors
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        if (is_null($request->query('access_token')) || $request->query('access_token') != env('EXPORT_TOKEN')) {
            abort(403);
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new PharmacyExport, 'farmacias.xls');
    }

    /**
     * @param Pharmacy $pharmacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Pharmacy $pharmacy)
    {
        $this->updaterService->enable($pharmacy);
        return response()->json(['message' => 'Farmácia ativada com sucesso']);
    }
}
