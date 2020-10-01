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
            $pharmacy->company_name = $pharmacyData['socialName'];
            $pharmacy->name = $pharmacyData['name'];
            $pharmacy->status = $pharmacyData['status'];
            $pharmacy->cnpj = preg_replace('/[^0-9]/', '', $pharmacyData['cnpj']);
            $pharmacy->state_registration = isset($pharmacyData['stateRegistration']) ? $pharmacyData['stateRegistration'] : null ;
            $pharmacy->email = isset($pharmacyData['email']) ? $pharmacyData['email'] : null;
            $pharmacy->phone = isset($pharmacyData['phone']) ? $pharmacyData['phone'] : null;
            $pharmacy->partner_priority = isset($pharmacyData['partnerPriority']) ? $pharmacyData['partnerPriority'] : null;
            $pharmacy->address = isset($pharmacyData['address']) ? $pharmacyData['address'] : null;
            $pharmacy->address_2 = isset($pharmacyData['address2']) ? $pharmacyData['address2'] : null;
            $pharmacy->address_number = isset($pharmacyData['addressNumber']) ? $pharmacyData['addressNumber'] : null;
            $pharmacy->district = isset($pharmacyData['district']) ? $pharmacyData['district'] : null;
            $pharmacy->zip_code = isset($pharmacyData['zipCode']) ? $pharmacyData['zipCode'] : null;
            $pharmacy->updated_id = auth()->guard('api')->user()->id;
            $pharmacy->city_id = isset($pharmacyData['cityId']) ? $pharmacyData['cityId'] : null;
            $pharmacy->supervisor_id = null;

            if (isset($pharmacyData['supervisor']) && isset($pharmacyData['supervisor']['id'])) {
                $pharmacy->supervisor_id = $pharmacyData['supervisor']['id'];
            }

            $city = null;

            if (isset($pharmacyData['cityIbgeCode']) && !empty($pharmacyData['cityIbgeCode'])) {
                $city = \App\City::where('ibge_code', $pharmacyData['cityIbgeCode'])->first();
            }


            if (!is_null($city)) {
                $pharmacy->city_id = $city->id;
            }


            $pharmacy->save();

            if (isset($pharmacyData['contacts'])) {
                foreach ($pharmacyData['contacts'] as $contact) {
                    $contact['updated_id'] = auth()->guard('api')->user()->id;
                    $pharmacy->contacts()->create($contact);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
