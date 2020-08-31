<?php

namespace App\Purchase\Services;

use App\Purchase;
use App\Purchase\Contracts\PurchaseCreatable;

class PurchaseCreator implements PurchaseCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $data['offer_id'] = $data['offerId'];
            $data['send_type'] = $data['sendType'];
            $data['validity_start'] = $data['validityStart'];
            $data['validity_end'] = $data['validityEnd'];
            $data['until_billing'] = $data['untilBilling'];
            $data['set_minimum_billing_value'] = $data['setMinimumBillingValue'];
            $data['minimum_billing_value'] = $data['MinimumBillingValue'];
            $data['set_minimum_billing_quantity'] = $data['setMinimumBillingQuantity'];
            $data['minimum_billing_quantity'] = $data['MinimumBillingQuantity'];
            $data['total_intentions_value'] = $data['totalIntentionsValue'];
            $data['total_intentions_quantity'] = $data['totalIntentionsQuantity'];
            $data['related_quantity'] = $data['relatedQuantity'];
            $model = Purchase::create($data);
            
            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $model->products()->create($item);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
