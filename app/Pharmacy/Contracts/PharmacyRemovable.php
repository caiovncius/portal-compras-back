<?php


namespace App\Pharmacy\Contracts;


use App\Pharmacy;

interface PharmacyRemovable
{

    /**
     * @param Pharmacy $pharmacy
     * @return bool
     * @throws \Exception
     */
    public function delete(Pharmacy $pharmacy);
}
