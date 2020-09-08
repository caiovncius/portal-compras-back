<?php

namespace App\Purchase\Services;

use App\Distributor;
use App\Partner;
use App\Program;
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
            $model->offer_id = isset($data['offerId']) ? $data['qw'] : null;
            $model->send_type = isset($data['sendType']) ? $data['sendType'] : null;
            $model->validity_start = isset($data['validityStart']) ? $data['validityStart'] : null;
            $model->validity_end = isset($data['validityEnd']) ? $data['validityEnd'] : null;
            $model->until_billing = isset($data['untilBilling']) ? $data['untilBilling'] : null;
            $model->set_minimum_billing_value = isset($data['setMinimumBillingValue']) ? $data['setMinimumBillingValue'] : null;
            $model->minimum_billing_value = isset($data['MinimumBillingValue']) ? $data['MinimumBillingValue'] : null;
            $model->set_minimum_billing_quantity = isset($data['setMinimumBillingQuantity']) ? $data['setMinimumBillingQuantity'] : null;
            $model->minimum_billing_quantity = isset($data['MinimumBillingQuantity']) ? $data['MinimumBillingQuantity'] : null;
            $model->total_intentions_value = isset($data['totalIntentionsValue']) ? $data['totalIntentionsValue'] : null;
            $model->total_intentions_quantity = isset($data['totalIntentionsQuantity']) ? $data['totalIntentionsQuantity'] : null;
            $model->related_quantity = isset($data['relatedQuantity']) ? $data['relatedQuantity'] : null;
            $model->save();
            $model->partners()->delete();

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

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
