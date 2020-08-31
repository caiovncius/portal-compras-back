<?php

namespace App\Product\Services;

use App\Product\Contracts\ProductDetailCreatable;

class ProductDetailCreator implements ProductDetailCreatable
{
    /**
     * @param int $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store($model, array $data)
    {
        try {
            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $item['discount_deferred'] = isset($item['discountDeferred']) ? $item['discountDeferred'] : null;
                    $item['discount_on_cash'] = isset($item['discountOnCash']) ? $item['discount_on_cash'] : null;
                    $item['minimum_per_family'] = isset($item['minimumPerFamily']) ? $item['minimum_per_family'] : null;
                    $item['factory_price'] = isset($item['factoryPrice']) ? $item['factoryPrice'] : null;
                    $item['price_deferred'] = isset($item['priceDeferred']) ? $item['priceDeferred'] : null;
                    $item['price_on_cash'] = isset($item['PriceOnCash']) ? $item['PriceOnCash'] : null;
                    $item['quantity_maximum'] = isset($item['quantityMaximum']) ? $item['quantityMaximum'] : null;
                    $item['quantity_minimum'] = isset($item['quantityMinimum']) ? $item['quantityMinimum'] : null;
                    $model->products()->create($item);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
