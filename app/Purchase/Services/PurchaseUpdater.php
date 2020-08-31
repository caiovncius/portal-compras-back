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
            $model->offer_id = $data['offerId'];
            $model->send_type = $data['sendType'];
            $model->validity_start = $data['validityStart'];
            $model->validity_end = $data['validityEnd'];
            $model->until_billing = $data['untilBilling'];
            $model->set_minimum_billing_value = $data['setMinimumBillingValue'];
            $model->minimum_billing_value = $data['MinimumBillingValue'];
            $model->set_minimum_billing_quantity = $data['setMinimumBillingQuantity'];
            $model->minimum_billing_quantity = $data['MinimumBillingQuantity'];
            $model->total_intentions_value = $data['totalIntentionsValue'];
            $model->total_intentions_quantity = $data['totalIntentionsQuantity'];
            $model->related_quantity = $data['relatedQuantity'];
            $model->save();
            
            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $model->products()->create($item);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
