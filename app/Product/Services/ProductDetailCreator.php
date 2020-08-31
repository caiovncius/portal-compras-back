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
                    $item['discount_deferred'] = $item['discountDeferred'];
                    $item['discount_on_cash'] = $item['discountOnCash'];
                    $item['minimum_per_family'] = $item['minimumPerFamily'];
                    $item['factory_price'] = $item['factoryPrice'];
                    $item['price_deferred'] = $item['priceDeferred'];
                    $item['price_on_cash'] = $item['PriceOnCash'];
                    $item['quantity_maximum'] = $item['quantityMaximum'];
                    $item['quantity_minimum'] = $item['quantityMinimum'];
                    $model->products()->create($item);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
