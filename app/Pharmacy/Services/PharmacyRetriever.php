<?php


namespace App\Pharmacy\Services;


use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyRetrievable;

class PharmacyRetriever implements PharmacyRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function pharmacies(array $params)
    {
        try {
            $query = Pharmacy::query();

            if (isset($params['code'])) {
                $query->where('code', 'like', '%' . $params['code'] . '%');
            }

            if (isset($params['cnpj'])) {
                $query->where('cnpj', $params['cnpj']);
            }

            if (isset($params['company_name'])) {
                $query->where('company_name', $params['company_name']);
            }

            if (isset($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['city_id'])) {
                $query->where('city_id', $params['city_id']);
            }

            if (isset($params['comercial'])) {
                $query->where('comercial', $params['comercial']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
