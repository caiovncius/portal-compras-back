<?php

namespace App\Condition\Services;

use App\Condition;
use App\Condition\Contracts\ConditionRetrievable;

class ConditionRetriever implements ConditionRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getConditions(array $params = [])
    {
        try {
            $query = Condition::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['pharmacy_id']) && !empty($params['pharmacy_id'])) {
                $query->where('pharmacy_id', $params['pharmacy_id']);
            }

            if (isset($params['description']) && !empty($params['description'])) {
                $query->where('desc', 'like', '%' . $params['description'] . '%');
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
