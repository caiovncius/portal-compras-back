<?php

namespace App\Offer\Services;

use App\Offer;
use App\Offer\Contracts\OfferProductRetrievable;

class OfferProductRetriever implements OfferProductRetrievable
{
    /**
     * @param Offer $model
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getProducts(Offer $model, array $params = [])
    {
        try {
            $query = $model->products()->query();

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('productName', 'like', '%' . $params['name'] . '%');
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
