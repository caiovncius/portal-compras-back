<?php


namespace App\Pharmacy\Contracts;


interface PharmacyCreatable
{
    /**
     * @param array $pharmacyData
     * @return bool
     * @throws \Exception
     */
    public function store(array $pharmacyData);
}
