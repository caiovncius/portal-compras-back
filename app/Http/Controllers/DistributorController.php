<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\Distributor\Contracts\DistributorCreatable;
use App\Distributor\Contracts\DistributorRemovable;
use App\Distributor\Contracts\DistributorRetrievable;
use App\Distributor\Contracts\DistributorUpdatable;
use App\Exports\DistributorExport;
use App\Http\Requests\DistributorCreatorRequest;
use App\Http\Requests\DistributorMassCreatorRequest;
use App\Http\Requests\DistributorMassUpdatorRequest;
use App\Http\Requests\DistributorUpdatorRequest;
use App\Http\Requests\ReturnMorphRequest;
use App\Http\Resources\DistributorListResource;
use App\Http\Resources\DistributorResource;
use App\Http\Resources\ReturnListResource;
use App\Returns\Contracts\ReturnsMorphCreatable;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * @var DistributorRetrievable
     */
    private $retrieverService;

    /**
     * @var DistributorCreatable
     */
    private $creatorService;

    /**
    * @var ReturnMorphCreatable
    */
    private $returnService;

    /**
     * @var DistributorUpdatable
     */
    private $updatorService;

    /**
     * @var DistributorRemovable
     */
    private $removerService;


    /**
     * DistributorController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(DistributorRetrievable::class);
        $this->creatorService = app()->make(DistributorCreatable::class);
        $this->returnService = app()->make(ReturnsMorphCreatable::class);
        $this->updatorService = app()->make(DistributorUpdatable::class);
        $this->removerService = app()->make(DistributorRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Distributors"},
     *     path="/distributors",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="00.0001/00001-14",
     *     ),
     *     @OA\Parameter(
     *        name="cnpj",
     *        in="query",
     *        example="00.0001/00001-14",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="ACTIVE",
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
     *                     @OA\Items(ref="#/components/schemas/DistributorListResource"),
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
            return DistributorListResource::collection($this->retrieverService->getDistributors($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Distributors"},
     *     path="/distributors/all",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(Request $request)
    {
        try {
            return DistributorListResource::collection($this->retrieverService->getDistributors($request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Distributors"},
     *     path="/distributors",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distribuidor criado com sucesso"
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
     * @param DistributorCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DistributorCreatorRequest $request)
    {
        try {
            $data = $this->creatorService->store($request->all());
            return response()->json(['message' => 'Distribuidor criado com sucesso', 'data' => $data], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/returns",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ReturnMorphRequest")
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
     *                     example ="retornos criados com sucesso"
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
     * @param ReturnMorphRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function returns(Distributor $distributor, ReturnMorphRequest $request)
    {
        try {
            $this->returnService->returns($distributor, $request->all());

            return response()->json(['message' => 'retornos criados com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorUpdatorRequest")
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
     * @param DistributorUpdatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DistributorUpdatorRequest $request, Distributor $distributor)
    {
        try {
            $this->updatorService->update($distributor, $request->all());
            return response()->json(['message' => 'Distribuidor atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}",
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
     *                     example ="Distribuidor removido com sucesso"
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
     * @param Distributor $distributor
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Distributor $distributor)
    {
        try {
            $this->removerService->delete($distributor);
            return response()->json(['message' => 'Distribuidor removido com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/DistributorResource"),
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
     * @param Distributor $distributor
     * @return DistributorResource
     */
    public function get(Distributor $distributor)
    {
        return DistributorResource::make($distributor);
    }

    /**
     *
     * @OA\Post(
     *     tags={"DistributorMassActions"},
     *     path="/mass-actions/distributor/create",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distributors criados com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param DistributorMassCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massStore(DistributorMassCreatorRequest $request)
    {

        $errors = [];
        $lines = 0;

        foreach ($request->data as $distributor) {

            $lines++;

            try {

                if (!isset($distributor['code']) || empty($distributor['code'])) {
                    $errors[] = [
                        'message' => 'code is required',
                        'data' => null
                    ];
                    continue;
                }

                $localData = Distributor::where('code', $distributor['code'])->first();

                if (!is_null($localData)) {
                    $errors[] = [
                        'message' => 'code already in use',
                        'data' => $distributor['code']
                    ];

                    continue;
                }

                $this->creatorService->store($distributor);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $distributor
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
     *     tags={"DistributorMassActions"},
     *     path="/mass-actions/distributor/update",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distributors atualizados com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param DistributorMassCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massUpdate(DistributorMassUpdatorRequest $request)
    {

        $errors = [];
        $lines = 0;

        foreach ($request->data as $model) {

            $lines++;

            try {

                if (!isset($model['code']) || empty($model['code'])) {
                    $errors[] = [
                        'message' => 'code is required',
                        'data' => null
                    ];
                    continue;
                }

                $localData = Distributor::where('code', $model['code'])->first();

                if (is_null($localData)) {
                    $errors[] = [
                        'message' => 'Entity not found',
                        'data' => $model['code']
                    ];

                    continue;
                }

                $this->updaterService->update($localData, $model);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $model
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
     *     tags={"DistributorMassActions"},
     *     path="/mass-actions/distributor/delete",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DistributorMassCreatorRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Distributors apagados com sucesso"
     *                 )
     *             )
     *         )
     *     ),
     *
     * )
     */

    /**
     * @param DistributorMassCreatorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDelete(DistributorMassCreatorRequest $request)
    {
        $errors = [];
        $lines = 0;

        foreach ($request->data as $model) {

            $lines++;

            try {

                if (!isset($model['code']) || empty($model['code'])) {
                    $errors[] = [
                        'message' => 'code is required',
                        'data' => null
                    ];
                    continue;
                }

                $localData = Distributor::where('code', $model['code'])->first();

                if (is_null($localData)) {
                    $errors[] = [
                        'message' => 'Entity not found',
                        'data' => $model['code']
                    ];

                    continue;
                }

                $this->removerService->delete($localData);

            } catch (\Exception $e) {
                $errors[] = [
                    'message' => $e->getMessage(),
                    'data' => $model
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
     * @OA\GET(
     *     tags={"Distributors"},
     *     path="/distributors/{distributor}/returns",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/ReturnListResource"),
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
     * @param Distributor $distributor
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function returnsByDistributor(Distributor $distributor)
    {
        try {
            return ReturnListResource::collection($this->retrieverService->getReturnsByDistributor($distributor)->paginate(20));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        if (is_null($request->query('access_token')) || $request->query('access_token') != env('EXPORT_TOKEN')) {
            abort(403);
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new DistributorExport(), 'distribuidoras.xls');
    }

    /**
     * @param Distributor $distributor
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Distributor $distributor)
    {
        $this->updatorService->enable($distributor);
        return response()->json(['message' => 'Distribuídora ativada com sucesso']);
    }
}
