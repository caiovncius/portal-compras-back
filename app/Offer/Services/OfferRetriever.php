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

            if (isset($params['sendType']) && !empty($params['sendType'])) {
                $query->where('sendType', $params['sendType']);
            }

            if (isset($params['startDate1']) && !empty($params['startDate1'])) {
                $query->whereDate('startDate', '>=', $params['startDate1']);
                if (isset($params['startDate2']) && !empty($params['startDate2'])) {
                    $query->whereDate('startDate', '<=', $params['startDate2']);                    
                }
            }

            if (isset($params['endDate1']) && !empty($params['endDate1'])) {
                $query->whereDate('endDate', '>=', $params['endDate1']);
                if (isset($params['endDate2']) && !empty($params['endDate2'])) {
                    $query->whereDate('endDate', '<=', $params['endDate2']);                    
                }
            }

            if (isset($params['partnerType']) && !empty($params['partnerType'])) {
                $partnerType = $params['partnerType'];
                $query->whereHas('partners', function ($related) use($partnerType) {
                    $related->where('distributor_offer.type', $partnerType);
                });
            }

            if (isset($params['partner']) && !empty($params['partner'])) {
                $partner = $params['partner'];
                $query->whereHas('partners', function ($related) use($partner) {
                    $related->where('distributor_offer.distributor_id', $partner);
                });
            }

            if (isset($params['partnerType']) && !empty($params['partnerType'])) {
                $partner = $params['partnerType'];
                $query->whereHas('partners', function ($related) use($partner) {
                    $related->where('type', $partner);
                });
            }

            if (isset($params['product']) && !empty($params['product'])) {
                $product = $params['product'];
                $query->whereHas('products', function ($related) use($product) {
                    $related->where('description', 'like', "%$product%");
                });
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
