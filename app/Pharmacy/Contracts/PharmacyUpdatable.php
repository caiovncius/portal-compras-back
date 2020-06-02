<?php


namespace App\Pharmacy\Contracts;


use App\Pharmacy;

interface PharmacyUpdatable
{
    /**
     * @param Pharmacy $pharmacy
     * @param array $pharmacyData
     * @return bool
     * @throws \Exception
     */
    public function update(Pharmacy $pharmacy, array $pharmacyData);
}
