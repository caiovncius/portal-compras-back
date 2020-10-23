<?php

namespace App\Purchase\Services;

use App\Distributor;
use App\Helpers\FileUploader;
use App\Partner;
use App\ProductDetail;
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
            $data['billing_measure'] = $data['billingMeasure'];
            $data['minimum_family'] = isset($data['minimumPerFamily']) ? $data['minimumPerFamily'] : 0;
            $data['minimum_billing_value'] = isset($data['minimumBillingValue']) && $data['billingMeasure'] === Purchase::BILLING_TYPE_VALUE ? $data['minimumBillingValue'] : null;
            $data['minimum_billing_quantity'] = isset($data['minimumBillingQuantity']) && $data['billingMeasure'] === Purchase::BILLING_TYPE_QUANTITY ? $data['minimumBillingQuantity'] : null;
            $data['total_intentions_value'] = isset($data['totalIntentionsValue']) ? $data['totalIntentionsValue'] : null;
            $data['total_intentions_quantity'] = isset($data['totalIntentionsQuantity']) ? $data['totalIntentionsQuantity'] : null;
            $data['related_quantity'] = isset($data['relatedQuantity']) ? $data['relatedQuantity'] : null;

            if (isset($data['image'])) {
                $data['image'] = FileUploader::uploadFile($data['image']);
            }

            $model = Purchase::create($data);

            if (isset($data['partner']) && !is_null($data['partner'])) {
                $partnerType = Partner::PARTNER_TYPE_DISTRIBUTOR;
                $partner = Distributor::find($data['partner']);

                if ($data['partnerType'] === Partner::PARTNER_TYPE_PROGRAM) {
                    $partnerType = Partner::PARTNER_TYPE_PROGRAM;
                    $partner = Program::find($data['partner']);
                }

                if (is_null($partner)) {
                    throw new \Exception(sprintf('Parceiro %s não encontrado', $partner['id']));
                }

                $model->partner()->create([
                    'partner_type' => $partnerType,
                    'partner_id' => $partner->id,
                ]);
            }

            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {

                    $factoryPrice = isset($item['factoryPrice']) ? $item['factoryPrice'] : 0;
                    $discountOnCash = isset($item['discountOnCash']) ? $item['discountOnCash'] : 0;
                    $discountDeferred = isset($item['discountDeferred']) ? $item['discountDeferred'] : 0;

                    $model->products()->create([
                        'product_id' => $item['productId'],
                        'factory_price' => $factoryPrice,
                        'discount_deferred' => $discountDeferred,
                        'price_deferred' => ProductDetail::sumDiscount($factoryPrice, $discountDeferred),
                        'discount_on_cash' => $discountOnCash,
                        'price_on_cash' => ProductDetail::sumDiscount($factoryPrice, $discountOnCash),
                        'minimum' => isset($item['minimum']) ? $item['minimum'] : null,
                        'minimum_per_family' => null,
                        'obrigatory' => isset($item['obrigatory']) ? $item['obrigatory'] : null,
                        'variable' => isset($item['variable']) ? $item['variable'] : null,
                        'family' => isset($item['family']) ? $item['family'] : null,
                        'gift' => isset($item['gift']) ? $item['gift'] : null,
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
