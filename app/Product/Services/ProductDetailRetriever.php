<?php

namespace App\Product\Services;

use App\Product\Contracts\ProductDetailRetrievable;

class ProductDetailRetriever implements ProductDetailRetrievable
{
    /**
     * @param integer $model
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getProducts($model, array $params = [])
    {
        try {
            $query = $model->products()->query();

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
