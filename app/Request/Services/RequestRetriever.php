<?php

namespace App\Request\Services;

use App\Request;
use App\Request\Contracts\RequestRetrievable;

class RequestRetriever implements RequestRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getRequests(array $params = [])
    {
        try {
            $query = Request::query();

            if (isset($params['offerId']) && !empty($params['offerId'])) {
                $query->where('offer_id', $params['offerId']);
            }

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('id', $params['code']);
            }

            if (isset($params['pharmacyId']) && !empty($params['pharmacyId'])) {
                $query->where('pharmacy_id', $params['pharmacyId']);
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['type']) && !empty($params['type'])) {
                $type = $params['type'] == 'OFFER' ? 'App\Offer' : 'App\Purchase';
                $query->where('requestable_type', $type);
            }

            if (isset($params['sendType']) && !empty($params['sendType'])) {
                $type = $params['sendType'];
                $query->whereHasMorph(
                    'requestable',
                    ['App\Offer', 'App\Purchase'],
                    function (Builder $query) use ($type) {
                        $query->where('send_type', $type);
                    }
                );
            }

            if (isset($params['date1']) && !empty($params['date1'])) {
                $query->whereDate('send_date', '>=', $params['date1']);
                if (isset($params['date2']) && !empty($params['date2'])) {
                    $query->whereDate('send_date', '<=', $params['date2']);                    
                }
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
