<?php

namespace App\Purchase\Services;

use App\Purchase;
use App\Purchase\Contracts\PurchaseUpdatable;

class PurchaseUpdater implements PurchaseUpdatable
{
    /**
     * @param Purchase $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Purchase $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->offer_id = $data['offerId'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
