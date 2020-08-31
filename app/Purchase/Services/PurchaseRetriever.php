<?php

namespace App\Purchase\Services;

use App\Purchase;
use App\Purchase\Contracts\PurchaseRetrievable;

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
            $query = Purchase::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['validityStart']) && !empty($params['validityStart'])) {
                $query->whereDate('validity_start', '>=', $params['validityStart']);
                if (isset($params['validityEnd']) && !empty($params['validityEnd'])) {
                    $query->whereDate('validity_end', '<=', $params['validityEnd']);                    
                }
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
