<?php

namespace App\Pharmacy\Services;

use App\Functionality;
use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyUpdatable;

class PharmacyUpdator implements PharmacyUpdatable
{
    /**
     * @param Pharmacy $pharmacy
     * @param array $pharmacyData
     * @return bool
     * @throws \Exception
     */
    public function update(Pharmacy $pharmacy, array $pharmacyData)
    {
        try {
            $pharmacy->code = $pharmacyData['code'];
            $pharmacy->cnpj = $pharmacyData['cnpj'];
            $pharmacy->company_name = $pharmacyData['socialName'];
            $pharmacy->status = $pharmacyData['status'];
            $pharmacy->city_id = $pharmacyData['cityId'];
            $pharmacy->commercial = $pharmacyData['commercial'];
            $pharmacy->save();
            $pharmacy->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
