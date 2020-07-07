<?php

namespace App\Offer\Services;

use App\Offer;
use App\Offer\Contracts\OfferRetrievable;

class OfferRetriever implements OfferRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getOffers(array $params = [])
    {
        try {
            $query = Offer::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['startDate']) && !empty($params['startDate'])) {
                $query->where('startDate', '>=', $params['startDate']);
            }

            if (isset($params['endDate']) && !empty($params['endDate'])) {
                $query->where('endDate', '>=', $params['endDate']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
