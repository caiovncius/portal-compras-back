<?php


namespace App\Pharmacy\Services;


use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyRemovable;

class PharmacyRemover implements PharmacyRemovable
{

    /**
     * @param Pharmacy $pharmacy
     * @return bool
     * @throws \Exception
     */
    public function delete(Pharmacy $pharmacy)
    {
        try {
            $pharmacy->status = Pharmacy::PHARMACY_STATUS_INACTIVE;
            $pharmacy->save();
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
