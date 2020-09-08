<?php

namespace App\Purchase\Services;

<<<<<<< HEAD
use App\Distributor;
use App\Partner;
use App\Program;
=======
use App\ProductDetail;
>>>>>>> e3af2a0889cd8fd46db81e54dc6c92b3d2ee8300
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
            $model->updated_at = date('Y-m-d H:i:s');
            $model->offer_id = isset($data['offerId']) ? $data['qw'] : null;
            $model->send_type = isset($data['sendType']) ? $data['sendType'] : null;
            $model->validity_start = isset($data['validityStart']) ? $data['validityStart'] : null;
            $model->validity_end = isset($data['validityEnd']) ? $data['validityEnd'] : null;
            $model->until_billing = isset($data['untilBilling']) ? $data['untilBilling'] : null;
            $model->set_minimum_billing_value = isset($data['setMinimumBillingValue']) ? $data['setMinimumBillingValue'] : null;
            $model->minimum_billing_value = isset($data['minimumBillingValue']) ? $data['minimumBillingValue'] : null;
            $model->set_minimum_billing_quantity = isset($data['setMinimumBillingQuantity']) ? $data['setMinimumBillingQuantity'] : null;
            $model->minimum_billing_quantity = isset($data['minimumBillingQuantity']) ? $data['minimumBillingQuantity'] : null;
            $model->total_intentions_value = isset($data['totalIntentionsValue']) ? $data['totalIntentionsValue'] : null;
            $model->total_intentions_quantity = isset($data['totalIntentionsQuantity']) ? $data['totalIntentionsQuantity'] : null;
            $model->related_quantity = isset($data['relatedQuantity']) ? $data['relatedQuantity'] : null;
            $model->save();
<<<<<<< HEAD
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
            
=======

>>>>>>> e3af2a0889cd8fd46db81e54dc6c92b3d2ee8300
            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $model->products()->create([
                        'product_id' => $item['productId'],
                        'discount_deferred' => isset($item['discountDeferred']) ? $item['discountDeferred'] : null,
                        'discount_on_cash' => isset($item['discountOnCash']) ? $item['discountOnCash'] : null,
                        'minimum' => isset($item['minimum']) ? $item['minimum'] : null,
                        'minimum_per_family' => $item['minimumPerFamily'],
                        'obrigatory' => isset($item['obrigatory']) ? $item['obrigatory'] : null,
                        'variable' => isset($item['variable']) ? $item['variable'] : null,
                        'family' => isset($item['family']) ? $item['family'] : null,
                        'gift' => isset($item['gift']) ? $item['gift'] : null,
                        'factory_price' => isset($item['factoryPrice']) ? $item['factoryPrice'] : null,
                        'price_deferred' => isset($item['priceDeferred']) ? $item['priceDeferred'] : null,
                        'price_on_cash' => isset($item['priceOnCash']) ? $item['priceOnCash'] : null,
                        'quantity_maximum' => isset($item['quantityMaximum']) ? $item['quantityMaximum'] : null,
                        'quantity_minimum' => isset($item['quantityMinimum']) ? $item['quantityMinimum'] : null,
                        'state_id' => $item['stateId'],
                        'updated_id' => auth()->guard('api')->user()->id,
                    ]);

                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
