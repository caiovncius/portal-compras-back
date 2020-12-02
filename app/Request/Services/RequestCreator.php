<?php

namespace App\Request\Services;

use App\Jobs\AutomaticOffers;
use App\Jobs\ManualOffers;
use App\Offer;
use App\ProductDetail;
use App\Purchase;
use App\Request;
use App\Request\Contracts\RequestCreatable;

class RequestCreator implements RequestCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {

            $type = $data['modelType'] == 'OFFER' ? 'App\Offer' : 'App\Purchase';

            if ($data['modelType'] == 'OFFER') {
                $model = Offer::find($data['modelId']);
            } else {
                $model = Purchase::find($data['modelId']);
            }

            if (is_null($model)) {
                throw new \Exception(sprintf('Tipo %s não encontrado', $data['modelId']));
            }

            $data['updated_id'] = auth()->guard('api')->user()->id;
            $data['pharmacy_id'] = $data['pharmacyId'];
            $data['requestable_id'] = $data['modelId'];
            $data['requestable_type'] = $type;
            $data['payment_method'] = $data['paymentMethod'] === 'CASH' ? 'CASH' : 'TERM';
            $data['status'] = 'WAITING_RETURN';
            $request = Request::create($data);

            $total = 0;
            $subtotal = 0;
            $totalDiscount = 0;

            if (isset($data['products'])) {
                foreach ($data['products'] as $product) {

                    $productDetails = ProductDetail::find($product['offerProductId']);

                    $productUnitValue = Request::getProductUnitValue(
                        $productDetails,
                        $request->payment_method,
                        $product['quantity']
                    );

                    $productSubtotal = Request::getProductSubTotal(
                        $productDetails,
                        $product['quantity'],
                        $request->payment_method
                    );

                    $productTotalDiscount = Request::getProductTotalDiscount(
                        $productDetails,
                        $request->payment_method,
                        $productSubtotal,
                        $product['quantity']
                    );

                    $productTotal = Request::getProductTotal($productSubtotal, $productTotalDiscount);

                    $discount = Request::getProductDiscount(
                        $productDetails,
                        $request->payment_method,
                        $product['quantity']
                    );

                    $request->products()->attach($product['productId'], [
                        'requested_quantity' => $product['quantity'],
                        'status' => null,
                        'discount_percentage' => $discount,
                        'unit_value' => $productUnitValue,
                        'subtotal' => $productSubtotal,
                        'total_discount' => $productTotalDiscount,
                        'total' => $productTotal,
                    ]);

                    $totalDiscount += $productTotalDiscount;
                    $subtotal += $productSubtotal;
                    $total += $productTotal;
                }
            }

            $request->subtotal = $subtotal;
            $request->total_discount = $totalDiscount;
            $request->total = $total;
            $request->save();

            if ($model->send_type === 'AUTOMATIC') {
                AutomaticOffers::dispatch($request)->delay(now()->addSeconds(20))->onQueue('default');
            }

            if ($model->send_type === 'MANUAL') {
                ManualOffers::dispatch($model, $request)->delay(now()->addSeconds(20))->onQueue('default');
            }

            return $request;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
