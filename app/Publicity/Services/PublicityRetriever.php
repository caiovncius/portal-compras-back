<?php

namespace App\Publicity\Services;

use App\Publicity;
use App\Publicity\Contracts\PublicityRetrievable;

class PublicityRetriever implements PublicityRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getPublicities(array $params = [])
    {
        try {
            $query = Publicity::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['desc']) && !empty($params['desc'])) {
                $query->where('desc', $params['desc']);
            }

            if (isset($params['date_create']) && !empty($params['date_create'])) {
                $query->where('date_create', $params['date_create']);
            }

            if (isset($params['date_publish']) && !empty($params['date_publish'])) {
                $query->where('date_publish', $params['date_publish']);
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
