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
            $pharmacy = new Pharmacy();
            $pharmacy->code = $pharmacyData['code'];
            $pharmacy->cnpj = $pharmacyData['cnpj'];
            $pharmacy->company_name = $pharmacyData['socialName'];
            $pharmacy->status = $pharmacyData['status'];
            $pharmacy->city_id = $pharmacyData['cityId'];
            $pharmacy->commercial = $pharmacyData['commercial'];
            $pharmacy->save();


            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
