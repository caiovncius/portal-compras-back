<?php

namespace App\Pharmacy\Services;

use App\Functionality;
use App\Pharmacy;
use App\Pharmacy\Contracts\PharmacyUpdatable;

class PharmacyUpdator implements PharmacyUpdatable
{
    /**
     * @param Pharmacy $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Pharmacy $model, array $data)
    {
        try {
            $model->code = $data['code'];
            $model->company_name = $data['socialName'];
            $model->name = $data['name'];
            $model->status = $data['status'];
            $model->cnpj = $data['cnpj'];
            $model->state_registration = isset($data['stateRegistration']) ? $data['stateRegistration'] : null ;
            $model->email = isset($data['email']) ? $data['email'] : null;
            $model->phone = isset($data['phone']) ? $data['phone'] : null;
            $model->supervisor_id = isset($data['supervisorId']) ? $data['supervisorId'] : null;
            $model->partner_priority = isset($data['partnerPriority']) ? $data['partnerPriority'] : null;
            $model->address = isset($data['address']) ? $data['address'] : null;
            $model->address_2 = isset($data['address2']) ? $data['address2'] : null;
            $model->address_number = isset($data['addressNumber']) ? $data['addressNumber'] : null;
            $model->district = isset($data['district']) ? $data['district'] : null;
            $model->zip_code = isset($data['zipCode']) ? $data['zipCode'] : null;

            if (isset($data['cityId'])) {
                $model->city_id = $data['cityId'];
            }

            $model->updated_id = auth()->guard('api')->user()->id;
            $model->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param Pharmacy $pharmacy
     * @param array $contactData
     * @return bool
     * @throws \Exception
     */
    public function addContact(Pharmacy $pharmacy, array $contactData)
    {
        try {
            $contactData['updated_id'] = auth()->guard('api')->user()->id;
            $pharmacy->contacts()->create($contactData);
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
