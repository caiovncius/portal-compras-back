<?php


namespace App\Pharmacy\Services;


use App\City;
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
            $query = Pharmacy::with(['city', 'users']);

            if (isset($params['code'])) {
                $query->where('code', 'like', '%' . $params['code'] . '%');
            }

            if (isset($params['cnpj'])) {
                $query->where('cnpj', $params['cnpj']);
            }

            if (isset($params['socialName'])) {
                $query->where('company_name', 'like', '%'.$params['socialName'].'%');
            }

            if (isset($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['state']) && !isset($params['city'])) {
                $cities = City::where('state_id', $params['state'])->pluck('id');
                $query->whereIn('city_id', $cities );
            }

            if (isset($params['city'])) {
                $query->where('city_id', $params['city']);
            }

            if (isset($params['comercial'])) {
                $query->whereHas('users', function($q) use($params) {
                    $q->where('name', 'like', '%' . $params['comercial'] . '%');
                });
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
