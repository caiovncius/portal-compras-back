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
            $data['send_type'] = isset($data['sendType']) ? $data['sendType'] : null;
            $data['validity_start'] = isset($data['validityStart']) ? $data['validityStart'] : null;
            $data['validity_end'] = isset($data['validityEnd']) ? $data['validityEnd'] : null;
            $data['until_billing'] = isset($data['untilBilling']) ? $data['untilBilling'] : null;
            $data['set_minimum_billing_value'] = isset($data['setMinimumBillingValue']) ? $data['setMinimumBillingValue'] : null;
            $data['minimum_billing_value'] = isset($data['MinimumBillingValue']) ? $data['minimum_billing_value'] : null;
            $data['set_minimum_billing_quantity'] = isset($data['setMinimumBillingQuantity']) ? $data['set_minimum_billing_quantity'] : null;
            $data['minimum_billing_quantity'] = isset($data['MinimumBillingQuantity']) ? $data['minimum_billing_quantity'] : null;
            $data['total_intentions_value'] = isset($data['totalIntentionsValue']) ? $data['total_intentions_value'] : null;
            $data['total_intentions_quantity'] = isset($data['totalIntentionsQuantity']) ? $data['total_intentions_quantity'] : null;
            $data['related_quantity'] = isset($data['relatedQuantity']) ? $data['relatedQuantity'] : null;
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
