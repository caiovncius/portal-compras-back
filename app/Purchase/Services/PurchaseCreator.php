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
            $data['minimum_billing_value'] = isset($data['minimumBillingValue']) ? $data['minimumBillingValue'] : null;
            $data['set_minimum_billing_quantity'] = isset($data['setMinimumBillingQuantity']) ? $data['setMinimumBillingQuantity'] : null;
            $data['minimum_billing_quantity'] = isset($data['minimumBillingQuantity']) ? $data['minimumBillingQuantity'] : null;
            $data['total_intentions_value'] = isset($data['totalIntentionsValue']) ? $data['totalIntentionsValue'] : null;
            $data['total_intentions_quantity'] = isset($data['totalIntentionsQuantity']) ? $data['totalIntentionsQuantity'] : null;
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

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
