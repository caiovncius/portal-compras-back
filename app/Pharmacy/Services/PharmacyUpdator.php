<?php


namespace App\Pharmacy\Services;


use App\Functionality;
use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyUpdatable;

class PharmacyUpdator implements PharmacyUpdatable
{
    /**
     * @param Pharmacy $parmacy
     * @param array $parmacyData
     * @return bool
     * @throws \Exception
     */
    public function update(Pharmacy $parmacy, array $parmacyData)
    {
        try {
            $parmacy->fill($parmacyData);
            $parmacy->save();

            if (isset($parmacyData['functions'])) {
                $parmacy->functionalities()->detach();

                foreach ($parmacyData['functions'] as $function) {
                    $permission = Functionality::where('key',$function['key'])->first();
                    $parmacy->functionalities()->attach($permission->id, ['access_type' => $function['permission']]);
                }
            }

            return true;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
