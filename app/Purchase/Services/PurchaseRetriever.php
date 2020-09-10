<?php

namespace App\Purchase\Services;

use App\Purchase;
use App\Purchase\Contracts\PurchaseRetrievable;
use Illuminate\Support\Facades\DB;

class PurchaseRetriever implements PurchaseRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getPurchases(array $params = [])
    {
        try {
            $query = Purchase::query()->with(['requests']);

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['date']) && !empty($params['date'])) {
                $query->whereDate('validity_start', '>=', $params['date'])
                      ->whereDate('validity_end', '<=', $params['date']);
            }

            if (isset($params['startDate1']) && !empty($params['startDate1'])) {
                $query->whereDate('validity_start', '>=', $params['startDate1']);
                if (isset($params['startDate2']) && !empty($params['startDate2'])) {
                    $query->whereDate('validity_start', '<=', $params['startDate2']);
                }
            }

            if (isset($params['endDate1']) && !empty($params['endDate1'])) {
                $query->whereDate('validity_end', '>=', $params['endDate1']);
                if (isset($params['endDate2']) && !empty($params['endDate2'])) {
                    $query->whereDate('validity_end', '<=', $params['endDate2']);
                }
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
