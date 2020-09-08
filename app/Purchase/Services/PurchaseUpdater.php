<?php

namespace App\Purchase\Services;

use App\ProductDetail;
use App\Purchase;
use App\Purchase\Contracts\PurchaseUpdatable;

class PurchaseUpdater implements PurchaseUpdatable
{
    /**
     * @param Purchase $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Purchase $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->offer_id = isset($data['offerId']) ? $data['qw'] : null;
            $model->send_type = isset($data['sendType']) ? $data['sendType'] : null;
            $model->validity_start = isset($data['validityStart']) ? $data['validityStart'] : null;
            $model->validity_end = isset($data['validityEnd']) ? $data['validityEnd'] : null;
            $model->until_billing = isset($data['untilBilling']) ? $data['untilBilling'] : null;
            $model->set_minimum_billing_value = isset($data['setMinimumBillingValue']) ? $data['setMinimumBillingValue'] : null;
            $model->minimum_billing_value = isset($data['minimumBillingValue']) ? $data['minimumBillingValue'] : null;
            $model->set_minimum_billing_quantity = isset($data['setMinimumBillingQuantity']) ? $data['setMinimumBillingQuantity'] : null;
            $model->minimum_billing_quantity = isset($data['minimumBillingQuantity']) ? $data['minimumBillingQuantity'] : null;
            $model->total_intentions_value = isset($data['totalIntentionsValue']) ? $data['totalIntentionsValue'] : null;
            $model->total_intentions_quantity = isset($data['totalIntentionsQuantity']) ? $data['totalIntentionsQuantity'] : null;
            $model->related_quantity = isset($data['relatedQuantity']) ? $data['relatedQuantity'] : null;
            $model->save();

            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $product = new ProductDetail();
                    $product->product_id = $item['productId'];
                    $product->discount_deferred = isset($item['discountDeferred']) ? $item['discountDeferred'] : null;
                    $product->discount_on_cash = isset($item['discountOnCash']) ? $item['discountOnCash'] : null;
                    $product->minimum = isset($item['minimum']) ? $item['minimum'] : null;
                    $product->minimum_per_family = $item['minimumPerFamily'];
                    $product->obrigatory = isset($item['obrigatory']) ? $item['obrigatory'] : null;
                    $product->variable = isset($item['variable']) ? $item['variable'] : null;
                    $product->family = isset($item['family']) ? $item['family'] : null;
                    $product->gift = isset($item['gift']) ? $item['gift'] : null;
                    $product->factory_price = isset($item['factoryPrice']) ? $item['factoryPrice'] : null;
                    $product->price_deferred = isset($item['priceDeferred']) ? $item['priceDeferred'] : null;
                    $product->price_on_cash = isset($item['priceOnCash']) ? $item['priceOnCash'] : null;
                    $product->quantity_maximum = isset($item['quantityMaximum']) ? $item['quantityMaximum'] : null;
                    $product->quantity_minimum = isset($item['quantityMinimum']) ? $item['quantityMinimum'] : null;
                    $product->state_id = $item['stateId'];
                    $product->updated_id = auth()->guard('api')->user()->id;

                    $model->products()->create($product);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
