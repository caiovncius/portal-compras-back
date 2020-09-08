<?php

namespace App\Purchase\Services;

use App\Distributor;
use App\Partner;
use App\Program;
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
            $data['send_type'] = isset($data['sendType']) ? $data['sendType'] : null;
            $data['validity_start'] = isset($data['validityStart']) ? $data['validityStart'] : null;
            $data['validity_end'] = isset($data['validityEnd']) ? $data['validityEnd'] : null;
            $data['until_billing'] = isset($data['untilBilling']) ? $data['untilBilling'] : 0;
            $data['set_minimum_billing_value'] = isset($data['setMinimumBillingValue']) ? $data['setMinimumBillingValue'] : null;
            $data['minimum_billing_value'] = isset($data['MinimumBillingValue']) ? $data['minimum_billing_value'] : null;
            $data['set_minimum_billing_quantity'] = isset($data['setMinimumBillingQuantity']) ? $data['set_minimum_billing_quantity'] : null;
            $data['minimum_billing_quantity'] = isset($data['MinimumBillingQuantity']) ? $data['minimum_billing_quantity'] : null;
            $data['total_intentions_value'] = isset($data['totalIntentionsValue']) ? $data['total_intentions_value'] : null;
            $data['total_intentions_quantity'] = isset($data['totalIntentionsQuantity']) ? $data['total_intentions_quantity'] : null;
            $data['related_quantity'] = isset($data['relatedQuantity']) ? $data['relatedQuantity'] : null;
            $model = Purchase::create($data);

            foreach ($data['partners'] as $partner) {
                $partnerType = Partner::PARTNER_TYPE_DISTRIBUTOR;
                $hasPartner = Distributor::find($partner['id']);

                if ($partner['type'] === Partner::PARTNER_TYPE_PROGRAM) {
                    $partnerType = Partner::PARTNER_TYPE_PROGRAM;
                    $hasPartner = Program::find($partner['id']);
                }

                if (is_null($hasPartner)) {
                    throw new \Exception(sprintf('Parceiro %s não encontrado', $partner['id']));
                }

                $model->partners()->create([
                    'partner_type' => $partnerType,
                    'partner_id' => $partner['id'],
                    'ol' => $partner['ol'],
                    'priority' => $partner['priority'],
                ]);
            }
            
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
