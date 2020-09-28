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

    /**
     * @param Pharmacy $pharmacy
     * @param array $contactData
     * @return bool
     * @throws \Exception
     */
    public function addContact(Pharmacy $pharmacy, array $contactData);

    /**
     * @param Pharmacy $pharmacy
     * @return bool
     */
    public function enable(Pharmacy $pharmacy);
}
