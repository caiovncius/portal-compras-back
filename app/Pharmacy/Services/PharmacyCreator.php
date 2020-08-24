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
            $pharmacy->cnpj = $pharmacyData['cnpj'];
            $pharmacy->state_registration = isset($pharmacyData['state_registration']) ? $pharmacyData['state_registration'] : null ;
            $pharmacy->email = isset($pharmacyData['email']) ? $pharmacyData['email'] : null;
            $pharmacy->phone = isset($pharmacyData['phone']) ? $pharmacyData['phone'] : null;
            $pharmacy->supervisor_id = isset($pharmacyData['supervisor_id']) ? $pharmacyData['supervisor_id'] : null;
            $pharmacy->partner_priority = isset($pharmacyData['partner_priority']) ? $pharmacyData['partner_priority'] : null;
            $pharmacy->address = isset($pharmacyData['address']) ? $pharmacyData['address'] : null;
            $pharmacy->address_2 = isset($pharmacyData['address_2']) ? $pharmacyData['address_2'] : null;
            $pharmacy->address_number = isset($pharmacyData['address_number']) ? $pharmacyData['address_number'] : null;
            $pharmacy->district = isset($pharmacyData['district']) ? $pharmacyData['district'] : null;
            $pharmacy->zip_code = isset($pharmacyData['zip_code']) ? $pharmacyData['zip_code'] : null;
            $pharmacy->city_id = $pharmacyData['cityId'];
            $pharmacy->updated_id = auth()->guard('api')->user()->id;
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
