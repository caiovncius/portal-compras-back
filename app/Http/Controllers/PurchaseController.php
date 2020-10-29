<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProductsRequest;
use App\Http\Requests\PurchaseIntentionRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\ProductDetailPortalResource;
use App\Http\Resources\PurchaseHistoricResource;
use App\Http\Resources\PurchaseListResource;
use App\Http\Resources\PurchasePortalResource;
use App\Http\Resources\RequestIntentionResource;
use App\Http\Resources\RequestListResource;
use App\Http\Resources\RequestResource;
use App\Imports\OfferProductImport;
use App\Pharmacy;
use App\Product\Contracts\ProductDetailRetrievable;
use App\Purchase;
use App\Request as RequestModel;
use App\Purchase\Contracts\PurchaseCreatable;
use App\Purchase\Contracts\PurchaseRemovable;
use App\Purchase\Contracts\PurchaseRetrievable;
use App\Purchase\Contracts\PurchaseUpdatable;
use App\Services\RequestPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    /**
     * @var PurchaseRetrievable
     */
    private $retrieverService;

    /**
     * @var ProductDetailRetrievable
     */
    private $productRetrieverService;

    /**
     * @var PurchaseCreatable
     */
    private $creatorService;

    /**
     * @var PurchaseUpdatable
     */
    private $updatorService;

    /**
     * @var PurchaseRemovable
     */
    private $removerService;


    /**
     * PurchaseController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(PurchaseRetrievable::class);
        $this->productRetrieverService = app()->make(ProductDetailRetrievable::class);
        $this->creatorService = app()->make(PurchaseCreatable::class);
        $this->updatorService = app()->make(PurchaseUpdatable::class);
        $this->removerService = app()->make(PurchaseRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Purchases"},
     *     path="/purchases",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
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
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/PurchaseListResource"),
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
            return PurchaseListResource::collection($this->retrieverService->getPurchases($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/purchases",
     *     @OA\Parameter(
     *        name="code",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="name",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="OPEN",
     *     ),
     *     @OA\Parameter(
     *        name="validityStart",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="validityEnd",
     *        in="query",
     *        example="2020-06-25",
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
     *                     @OA\Items(ref="#/components/schemas/PurchaseListResource"),
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
     * @param Pharmacy|null $pharmacy
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function portal(Request $request, \App\Pharmacy $pharmacy = null)
    {
        try {
            $input = $request->all();
            $input['status'] = 'OPEN';

            $purchases = $this->retrieverService->getPurchases($input)->get();

            $purchases->each(function($purchase) use($request) {
                $purchase->hasRequest = !$request->query('pharmacyId')
                    ? false
                    : $purchase->requests()
                        ->where('pharmacy_id', $request->query('pharmacyId'))
                        ->count() > 0;
            });

            return PurchasePortalResource::collection($purchases);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/purchases/{id}/products",
     *     @OA\Parameter(
     *        name="name",
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
     *                     @OA\Items(ref="#/components/schemas/ProductDetailPortalResource"),
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    /**
     * @param Request $request
     * @param Purchase $model
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function products(Purchase $model, Request $request)
    {
        try {
            $input = $request->all();
            $input['productable_id'] = $model->id;
            $input['productable_type'] = 'App\Purchase';

            if ($request->query('pharmacyId')) {
                $pharmacy = Pharmacy::find($request->query('pharmacyId'));
                if (!is_null($pharmacy)) $input['stateId'] = $pharmacy->city->state->id;
            }

            return ProductDetailPortalResource::collection($this->productRetrieverService->getProducts($input)->get());
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Purchases"},
     *     path="/purchases",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PurchaseRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Compra criada com sucesso"
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
     * @param PurchaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PurchaseRequest $request)
    {
        try {
            $this->creatorService->store($request->all());
            return response()->json(['message' => 'Compra criada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     tags={"Purchases"},
     *     path="/purchases/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PurchaseRequest")
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
     *                     example ="Compra atualizada com sucesso"
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
     * @param PurchaseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PurchaseRequest $request, Purchase $model)
    {
        try {
            $this->updatorService->update($model, $request->all());
            return response()->json(['message' => 'Compra atualizada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Purchases"},
     *     path="/purchases/{id}",
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
     *                     example ="Compra removida com sucesso"
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
     * @param Purchase $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Purchase $model)
    {
        try {
            $this->removerService->delete($model);
            return response()->json(['message' => 'Compra removida com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\GET(
     *     tags={"Purchases"},
     *     path="/purchases/{id}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/PurchaseListResource"),
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
     * @param Request $request
     * @param Purchase $model
     * @return PurchaseListResource
     */
    public function get(Request $request, Purchase $model)
    {
        $purchaseQuery = Purchase::query();

        if ($request->query('pharmacyId') && !empty($request->query('pharmacyId'))) {

            $pharmacy = Pharmacy::find($request->query('pharmacyId'));

            $purchaseQuery->with(['products' => function($query) use($pharmacy) {
                $query->where('state_id', $pharmacy->city->state->id);
            }]);
        }

        $purchase = $purchaseQuery->first();


        return PurchaseListResource::make($purchase);
    }

    /**
     * @param Purchase $purchase
     * @return \Illuminate\Http\JsonResponse
     */
    /// TODO: add it on service
    public function intentions(Purchase $purchase)
    {
       try {
           $allIntentions = $purchase->requests()->get();
           $totalIntentions = $allIntentions->count();
           $amountIntentions = $allIntentions->sum('value');
           return response()->json([
               'totalIntentions' => $totalIntentions,
               'amountIntentions' => $amountIntentions,
               'intentions' => RequestIntentionResource::collection($allIntentions)
           ]);
       } catch (\Exception $exception) {
           return response()->json(['error' => $exception->getMessage()], 400);
       }
    }

    /**
     *
     * @OA\POST(
     *     tags={"Purchases"},
     *     path="/purchases/{id}/intentions",
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        example="2",
     *        required=true
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PurchaseIntentionRequest")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Intenções enviadas com sucesso"
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
     * @param Purchase $purchase
     * @return \Illuminate\Http\JsonResponse
     */
    /// TODO: add it on service
    public function intentionsSend(Purchase $purchase, PurchaseIntentionRequest $request)
    {
        try {
            foreach ($request->requests as $request) {
                $requestModel = RequestModel::find($request['id']);

                (new RequestPurchase())->send($requestModel);
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    // TODO: add it on service and create a resource
    public function historic(Purchase $purchase)
    {
        try {
            $histories = [];
            foreach ($purchase->requests()->get() as $request) {
                foreach ($request->historics as $history) {
                    $histories[] = [
                        'date' => $history->created_at,
                        'username' => $history->user,
                        'action' => $history->action,
                        'status' => $history->status
                    ];
                }
            }

            return response()->json($histories);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @param ImportProductsRequest $request
     * @param Purchase $purchase
     * @return \Illuminate\Http\JsonResponse
     */
    public function importProducts(ImportProductsRequest $request, Purchase $purchase)
    {
        $base64Data = explode('base64,', $request->file);
        $fileData = base64_decode(end($base64Data));
        $tmpName = time() . '.xlsx';
        Storage::put("/spreadsheets/{$tmpName}", $fileData);
        $importParams = $request->all();
        unset($importParams['file']);
        $import = new OfferProductImport($purchase, $importParams);
        $import->import(storage_path('app/spreadsheets/' . $tmpName));

        $response = [
            'total_imported_rows' => $import->getRowCount(),
            'total_errors' => $import->failures()->count(),
            'errors' => []
        ];

        foreach ($import->failures() as $failure) {
            $response['errors'][] = [
                'row' => $failure->row(),
                'col' => $import->cols[$failure->attribute()],
                'errors' => $failure->errors()
            ];
        }

        return response()->json(['errors' => $response], 200);
    }
}
