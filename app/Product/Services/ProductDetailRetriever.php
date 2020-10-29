<?php

namespace App\Product\Services;

use App\ProductDetail;
use App\Product\Contracts\ProductDetailRetrievable;
use Illuminate\Database\Eloquent\Builder;

class ProductDetailRetriever implements ProductDetailRetrievable
{
    /**
     * @param integer $model
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getProducts(array $params = [])
    {
        try {
            $query = ProductDetail::query();
            $query->groupBy('product_id');
            $query->where('productable_id', $params['productable_id']);
            $query->where('productable_type', $params['productable_type']);

            if (isset($params['stateId']) && !empty($params['stateId'])) {
                $query->where('state_id', $params['stateId']);
            }

            if (isset($params['name']) && $params['name'] !== '') {
                $name = $params['name'];
                $query->whereHas('product', function(Builder $query) use ($name) {
                    $query->where('description', 'like', '%'.$name.'%')
                    ->orWhere('code_ean', 'like', '%'.$name.'%');
                });
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
