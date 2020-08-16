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
            $model->cnpj = $data['cnpj'];
            $model->company_name = $data['socialName'];
            $model->status = $data['status'];
            $model->city_id = $data['cityId'];
            $model->commercial = $data['commercial'];
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
