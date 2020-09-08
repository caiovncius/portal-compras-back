<?php

namespace App\Distributor\Services;

use App\Distributor;
use App\Distributor\Contracts\DistributorRetrievable;

class DistributorRetriever implements DistributorRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getDistributors(array $params = [])
    {
        try {
            $query = Distributor::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['cnpj']) && !empty($params['cnpj'])) {
                $query->where('cnpj', $params['cnpj']);
            }

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
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

    /**
     * @param Distributor $distributor
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * @throws \Exception
     */
    public function getReturnsByDistributor(\App\Distributor $distributor)
    {
        try {
            return $distributor->returns();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
