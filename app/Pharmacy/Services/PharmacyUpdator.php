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
            $model->cnpj = preg_replace('/[^0-9]/', '', $data['cnpj']);
            $model->state_registration = isset($data['stateRegistration']) ? $data['stateRegistration'] : null ;
            $model->email = isset($data['email']) ? $data['email'] : null;
            $model->phone = isset($data['phone']) ? $data['phone'] : null;
            $model->partner_priority = isset($data['partnerPriority']) ? $data['partnerPriority'] : null;
            $model->address = isset($data['address']) ? $data['address'] : null;
            $model->address_2 = isset($data['address2']) ? $data['address2'] : null;
            $model->address_number = isset($data['addressNumber']) ? $data['addressNumber'] : null;
            $model->district = isset($data['district']) ? $data['district'] : null;
            $model->zip_code = isset($data['zipCode']) ? $data['zipCode'] : null;

            $model->supervisor_id = null;

            if (isset($data['supervisor']) && isset($data['supervisor']['id'])) {
                $model->supervisor_id = $data['supervisor']['id'];
            }

            if (isset($data['cityId'])) {
                $model->city_id = $data['cityId'];
            }

            $city = null;

            if (isset($pharmacyData['cityIbgeCode']) && !empty($pharmacyData['cityIbgeCode'])) {
                $city = \App\City::where('ibge_code', $pharmacyData['cityIbgeCode'])->first();
            }

            if (!is_null($city)) {
                $model->city_id = $city->id;
            }

            $model->updated_id = auth()->guard('api')->user()->id;
            $model->save();

            if (isset($data['contacts'])) {
                $model->contacts()->delete();
                foreach ($data['contacts'] as $contact) {
                    $contact['updated_id'] = auth()->guard('api')->user()->id;
                    $model->contacts()->create($contact);
                }
            }

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

    /**
     * @param Pharmacy $pharmacy
     * @return bool
     */
    public function enable(Pharmacy $pharmacy)
    {
        $pharmacy->status = Pharmacy::PHARMACY_STATUS_ACTIVE;
        $pharmacy->save();
        return true;
    }
}
