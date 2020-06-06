<?php

namespace App\Returns\Services;

use App\Returns;
use App\Returns\Contracts\ReturnsRetrievable;

class ReturnsRetriever implements ReturnsRetrievable
{
    /**
     * @param array $params
     * @Returns \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getReturns(array $params = [])
    {
        try {
            $query = Returns::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['desc']) && !empty($params['desc'])) {
                $query->where('desc', $params['desc']);
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['createdAt']) && !empty($params['createdAt'])) {
                $query->where('created_at', '>=', $params['created_at']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
