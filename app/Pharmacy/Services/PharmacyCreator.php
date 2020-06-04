<?php


namespace App\Pharmacy\Services;


use App\Functionality;
use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyCreatable;

class PharmacyCreator implements PharmacyCreatable
{
    /**
     * @param array $pharmacyData
     * @return bool
     * @throws \Exception
     */
    public function store(array $pharmacyData)
    {
        try {
            $pharmacy = Pharmacy::create($pharmacyData);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
