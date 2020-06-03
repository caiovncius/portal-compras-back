<?php


namespace App\Pharmacy\Services;


use App\Functionality;
use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyUpdatable;

class PharmacyUpdator implements PharmacyUpdatable
{
    /**
     * @param Pharmacy $parmacy
     * @param array $pharmacyData
     * @return bool
     * @throws \Exception
     */
    public function update(Pharmacy $parmacy, array $pharmacyData)
    {
        try {
            $parmacy->fill($pharmacyData);
            $parmacy->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
