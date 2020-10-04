<?php


namespace App\Laboratory\Services;


use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryRetrievable;

class LaboratoryRetriever implements LaboratoryRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function laboratories(array $params)
    {
        try {
            $query = Laboratory::query();

            if (isset($params['code'])) {
                $query->where('code', 'like', '%' . $params['code'] . '%');
            }

            if (isset($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['cnpj'])) {
                $query->where('cnpj', 'like',  '%' . $params['cnpj'] . '%');
            }

            if (isset($params['name'])) {
                $query->where('name', 'like',  '%' . $params['name'] . '%');
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
