<?php

namespace App\Http\Controllers;

use App\Exports\AttendancesExport;
use App\Exports\DistributorExport;
use App\Exports\RequestExport;
use App\Http\Requests\RequestProductRequest;
use App\Http\Requests\RequestRequest;
use App\Http\Requests\RequestUpdateProductsStatusesRequest;
use App\Http\Requests\RequestUpdateProductsStatusRequest;
use App\Http\Requests\SumItemRequest;
use App\Http\Resources\RequestListResource;
use App\Http\Resources\RequestMonitoringResource;
use App\Http\Resources\RequestResource;
use App\ProductDetail;
use App\Request as RequestModel;
use App\Request\Contracts\RequestCreatable;
use App\Request\Contracts\RequestProductUpdatable;
use App\Request\Contracts\RequestRemovable;
use App\Request\Contracts\RequestRetrievable;
use App\Request\Contracts\RequestUpdatable;
use App\Services\PortalDashboard;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * @var RequestRetrievable
     */
    private $retrieverService;

    /**
     * @var RequestCreatable
     */
    private $creatorService;

    /**
     * @var RequestUpdatable
     */
    private $updatorService;

    /**
     * @var RequestProductUpdatable
     */
    private $productUpdatorService;

    /**
     * @var RequestRemovable
     */
    private $removerService;


    /**
     * RequestController constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->retrieverService = app()->make(RequestRetrievable::class);
        $this->creatorService = app()->make(RequestCreatable::class);
        $this->updatorService = app()->make(RequestUpdatable::class);
        $this->productUpdatorService = app()->make(RequestProductUpdatable::class);
        $this->removerService = app()->make(RequestRemovable::class);
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/requests",
     *     @OA\Parameter(
     *        name="offerid",
     *        in="query",
     *        example="01",
     *     ),
     *     @OA\Parameter(
     *        name="pharmacyId",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Parameter(
     *        name="type",
     *        in="query",
     *        example="OFFER",
     *     ),
     *     @OA\Parameter(
     *        name="commercial",
     *        in="query",
     *        example="name",
     *     ),
     *     @OA\Parameter(
     *        name="sendType",
     *        in="query",
     *        example="MANUAL",
     *     ),
     *     @OA\Parameter(
     *        name="date1",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="date2",
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
     *                     @OA\Items(ref="#/components/schemas/RequestListResource"),
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
            return RequestListResource::collection($this->retrieverService->getRequests($request->query())->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/dashboard",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/RequestListResource"),
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function dashboard()
    {
        try {
            return (new PortalDashboard())->dashboard();
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Portal"},
     *     path="/portal/pharmacies/{id}/requests",
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(ref="#/components/schemas/RequestListResource"),
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
     * @param integer $pharmacy
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function byPharmacy($pharmacy)
    {
        try {
            $input['pharmacyId'] = $pharmacy;

            return RequestListResource::collection($this->retrieverService->getRequests($input)->paginate(10));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Post(
     *     tags={"Portal"},
     *     path="/portal/requests",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RequestRequest")
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
     * @param RequestRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RequestRequest $request)
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
     *     tags={"Portal"},
     *     path="/portal/requests/{id}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RequestRequest")
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
     * @param RequestRequest $request
     * @param RequestModel $model
     * @param string $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RequestProductRequest $request, RequestModel $model)
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
     * @OA\Put(
     *     tags={"Portal"},
     *     path="/portal/requests/{id}/products/{product?}",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RequestProductRequest")
     *      ),
     *     @OA\Parameter(
     *        name="status",
     *        in="path",
     *        example="ATTENDED",
     *        required=true
     *     ),
     *     @OA\Parameter(
     *        name="returnId",
     *        in="path",
     *        example="5",
     *        required=true
     *     ),
     *     @OA\Parameter(
     *        name="qtdReturn",
     *        in="path",
     *        example="10",
     *        required=false
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="message",
     *                     example ="Produto atualizado com sucesso"
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
     * @param RequestProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProducts(RequestProductRequest $request, RequestModel $model, $product = '')
    {
        try {
            $this->productUpdatorService->update($model, $product, $request->all());
            return response()->json(['message' => 'Compra atualizada com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     tags={"Portal"},
     *     path="/portal/requests/{id}",
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
     * @param Request $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(RequestModel $model)
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
     *     tags={"Portal"},
     *     path="/portal/requests/{id}",
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
     *                 @OA\Property(property="data", ref="#/components/schemas/RequestResource"),
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
     * @param RequestModel $model
     * @return RequestResource
     */
    public function get(RequestModel $model)
    {
        $request = $model;
        $request->products->each(function ($product) use($request) {
            $product->offerDetails = $product->details()
                ->where('productable_type', $request->requestable_type)
                ->where('productable_id', $request->requestable_id)
                ->first();
            $product->paymentMethod = $request->payment_method;
        });
        return RequestResource::make($request);
    }

    /**
     * @OA\Get(
     *     tags={"Accompaniment"},
     *     path="/accompaniments",
     *     @OA\Parameter(
     *        name="offerCode",
     *        in="query",
     *        example="OFFER9980",
     *     ),
     *     @OA\Parameter(
     *        name="pharmacyId",
     *        in="query",
     *        example="teste",
     *     ),
     *     @OA\Parameter(
     *        name="status",
     *        in="query",
     *        example="active",
     *     ),
     *     @OA\Parameter(
     *        name="type",
     *        in="query",
     *        example="OFFER",
     *     ),
     *     @OA\Parameter(
     *        name="commercial",
     *        in="query",
     *        example="name",
     *     ),
     *     @OA\Parameter(
     *        name="sendType",
     *        in="query",
     *        example="MANUAL",
     *     ),
     *     @OA\Parameter(
     *        name="date1",
     *        in="query",
     *        example="2020-05-25",
     *     ),
     *     @OA\Parameter(
     *        name="date2",
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
     *                     @OA\Items(ref="#/components/schemas/RequestListResource"),
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
    public function toMonitory(Request $request)
    {
        try {
            return RequestMonitoringResource::collection(
                $this->retrieverService->getRequests($request->all())
                    ->orderBy('id', 'DESC')
                    ->paginate(10)
            );
        } catch (\Exception $exception) {
            dd($exception);
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @param RequestModel $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelRequest(\App\Request $request)
    {
        try {
            $this->updatorService->cancel($request);
            return response()->json(['message' => 'Pedido cancelado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function accompaniments(Request $request)
    {
        try {
            $params = $request->all();
            $params['pharmacies'] = auth()->guard('api')->user()->pharmacies()->pluck('id');

            return RequestMonitoringResource::collection(
                $this->retrieverService->getRequests($params)
                    ->orderBy('id', 'DESC')
                    ->paginate(10)
            );
        } catch (\Exception $exception) {
            dd($exception);
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @param RequestUpdateProductsStatusRequest $request
     * @param RequestModel $requestModel
     * @return \Illuminate\Http\JsonResponse
     */
    public function massUpdateAllProductStatus(RequestUpdateProductsStatusRequest $request, RequestModel $requestModel)
    {
        try {
            $this->updatorService->updateAllProductStatus($requestModel, $request->status, $request->returnId);
            return response()->json(['message' => 'Status atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @param RequestUpdateProductsStatusesRequest $request
     * @param RequestModel $requestModel
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAllProductStatus(RequestUpdateProductsStatusesRequest $request, RequestModel $requestModel)
    {
        try {
            $this->updatorService->massUpdateProductStatus($requestModel, $request->items);
            return response()->json(['message' => 'Status atualizado com sucesso'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * @param SumItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sumItem(SumItemRequest $request)
    {
        $productDetails = ProductDetail::find($request->offerProduct);

        $productUnitValue = \App\Request::getProductUnitValue(
            $productDetails,
            $request->paymentMethod,
            $request->quantity
        );

        $productSubtotal = \App\Request::getProductSubTotal(
            $productDetails,
            $request->quantity,
            $request->paymentMethod
        );

        $productTotalDiscount = \App\Request::getProductTotalDiscount(
            $productDetails,
            $request->paymentMethod,
            $productSubtotal,
            $request->quantity
        );

        $productTotal = \App\Request::getProductTotal($productSubtotal, $productTotalDiscount);

        $discount = \App\Request::getProductDiscount(
            $productDetails,
            $request->paymentMethod,
            $request->quantity
        );

        return response()->json([
            'quantity' => $request->quantity,
            'discountPercentage' => $discount,
            'unitValue' => $productUnitValue,
            'subtotal' => $productSubtotal,
            'totalDiscount' => $productTotalDiscount,
            'total' => $productTotal,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        if (is_null($request->query('access_token')) || $request->query('access_token') != env('EXPORT_TOKEN')) {
            abort(403);
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new AttendancesExport(), 'pedidos.xls');
    }
}
