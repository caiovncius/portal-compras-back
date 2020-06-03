<?php


namespace App\Pharmacy\Contracts;


use App\Pharmacy;

interface PharmacyRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function pharmacies(array $params);
}
