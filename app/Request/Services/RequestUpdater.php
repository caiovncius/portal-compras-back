<?php

namespace App\Request\Services;

use App\Request;
use App\Request\Contracts\RequestUpdatable;

class RequestUpdater implements RequestUpdatable
{
    /**
     * @param Request $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Request $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->pharmacy_id = $data['pharmacyId'];
            $model->offer_id = $data['offerId'];
            $model->save();

            if (isset($data['products'])) {
                $model->products()->detach();
                foreach ($data['products'] as $data) {
                    $model->products()->attach($data['id'], ['qtd' => $data['qtd']]);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
