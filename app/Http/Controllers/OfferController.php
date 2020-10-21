<?php

namespace App\Http\Controllers;

use App\Distributor;
use App\Http\Requests\ImportProductsRequest;
use App\Http\Requests\OfferCreatorRequest;
use App\Http\Requests\OfferUpdatorRequest;
use App\Http\Resources\OfferListResource;
use App\Http\Resources\OfferPortalResource;
use App\Http\Resources\PartnerListResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\PartnerToAutocompleteResource;
use App\Http\Resources\ProductDetailPortalResource;
use App\Imports\OfferProductImport;
use App\Offer;
use App\Offer\Contracts\OfferCreatable;
use App\Partner;
use App\Product\Contracts\ProductDetailRetrievable;
use App\Offer\Contracts\OfferRemovable;
use App\Offer\Contracts\OfferRetrievable;
use App\Offer\Contracts\OfferUpdatable;
use App\Program;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class OfferController extends Controller
{
    /**
     * @var OfferRetrievable
     */
    private $retrieverService;

    /**
     * @var ProductDetailRetrievable
     */
    private $productRetrieverService;

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
        $this->productRetrieverService = app()->make(ProductDetailRetrievable::class);
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
     *        name="partner",
     *        in="query",
     *        example="1",
     *     ),
     *     @OA\Parameter(
     *        name="partnerType",
     *        in="query",
     *        example="DISTRIBUTOR",
     *     ),
     *     @OA\Parameter(
     *        name="startDate1",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="startDate2",
     *        in="query",
     *        example="2020-05-27",
     *     ),
     *     @OA\Parameter(
     *        name="endDate1",
     *        in="query",
     *        example="2020-06-25",
     *     ),
     *     @OA\Parameter(
     *        name="endDate2",
     *        in="query",
     *        example="2020-06-27",
     *     ),
     *     @OA\Parameter(
     *        name="product",
     *        in="query",
     *        example="1",
     *     ),
     *     @OA\Parameter(
     *        name="offerId",
     *        in="query",
     *        example="1",
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
            return OfferListResource::collection($this->retrieverService->getOffers($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/offers",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="partner",
     *        in="query",
     *        example="1",
     *     ),
     *     @OA\Parameter(
     *        name="partnerType",
     *        in="query",
     *        example="DISTRIBUTOR",
     *     ),
     *     @OA\Parameter(
     *        name="product",
     *        in="query",
     *        example="1",
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
     *                     @OA\Items(ref="#/components/schemas/OfferPortalResource"),
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
    public function portal(Request $request)
    {
        try {
            $input = $request->all();
            $input['status'] = 'ACTIVE';
            $input['endDate1'] = Carbon::today()->format('Y-m-d');

            return OfferPortalResource::collection($this->retrieverService->getOffers($input)->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/offers/{id}/products",
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="payment",
     *        in="query",
     *        example="CASH/DEFERRED",
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
     *                     @OA\Items(ref="#/components/schemas/ProductDetailPortalResource"),
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @param Offer $model
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function products(Offer $model, Request $request)
    {
        try {
            $input = $request->all();
            $input['productable_id'] = $model->id;
            $input['productable_type'] = 'App\Offer';

            return ProductDetailPortalResource::collection($this->productRetrieverService->getProducts($input)->get());
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
     *                     example ="Oferta criado com sucesso"
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
            return response()->json(['message' => 'Oferta criado com sucesso'], 200);
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
            return response()->json(['message' => 'Oferta atualizado com sucesso'], 200);
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

    /**
     * @OA\Get(
     *     tags={"Offers"},
     *     path="/offers/search",
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
     *        name="partner",
     *        in="query",
     *        example="1",
     *     ),
     *     @OA\Parameter(
     *        name="partnerType",
     *        in="query",
     *        example="DISTRIBUTOR",
     *     ),
     *     @OA\Parameter(
     *        name="startDate",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="endDate",
     *        in="query",
     *        example="2020-06-25",
     *     ),
     *     @OA\Parameter(
     *        name="product",
     *        in="query",
     *        example="1",
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
            return OfferListResource::collection($this->retrieverService->getOffers($request->query())->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function enable(Offer $offer)
    {
        $this->updatorService->enable($offer);
        return response()->json(['message' => 'Oferta ativada com sucesso']);
    }

    /**
     * @param ImportProductsRequest $request
     * @param Offer $offer
     * @return \Illuminate\Http\JsonResponse
     */
    public function importProducts(ImportProductsRequest $request, Offer $offer)
    {
        $base64Data = explode('base64,', $request->file);
        $fileData = base64_decode(end($base64Data));
        $tmpName = time() . '.xlsx';
        Storage::put("/spreadsheets/{$tmpName}", $fileData);
        $importParams = $request->all();
        unset($importParams['file']);
        $import = new OfferProductImport($offer, $importParams);
        $import->import(storage_path('app/spreadsheets/' . $tmpName));

        $response = [
            'totalImportedRows' => $import->getRowCount(),
            'totalErrors' => $import->failures()->count(),
            'errors' => []
        ];

        foreach ($import->failures() as $failure) {
            $response['errors'][] = [
                'row' => $failure->row(),
                'col' => $import->cols[$failure->attribute()],
                'errors' => $failure->errors()
            ];
        }


        return response()->json($response, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPartners(Request $request)
    {
        $distributorsQuery = Distributor::query()->select('id','name');

        $programsQuery = Program::query()->select('id','name')->unionAll($distributorsQuery);

        if ($request->query('type')) {
            if ($request->query('type') === 'DISTRIBUTOR') {
                $programsQuery = Distributor::query()->select('id','name');
            } else {
                $programsQuery = Program::query()->select('id','name');
            }
        }

        if ($request->query('name')) {
            $programsQuery->where('name', 'like', '%' . $request->query('name').'%');
        }

        $result = PartnerToAutocompleteResource::collection($programsQuery->get());
        return response()->json(['data' => $result]);
    }
}
