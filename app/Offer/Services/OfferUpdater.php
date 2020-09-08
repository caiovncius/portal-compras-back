<?php

namespace App\Offer\Services;

use App\Distributor;
use App\Helpers\FileUploader;
use App\Offer;
use App\Partner;
use App\Offer\Contracts\OfferUpdatable;
use App\Program;

class OfferUpdater implements OfferUpdatable
{
    /**
     * @param Offer $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Offer $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->start_date = isset($data['startDate']) ? $data['startDate'] : null;
            $model->end_date = isset($data['endDate']) ? $data['endDate'] : null;
            $model->minimum_price = isset($data['minimumPrice']) ? $data['minimumPrice'] : null;
            $model->offer_type = isset($data['offerType']) ? $data['offerType'] : null;
            $model->send_type = isset($data['sendType']) ? $data['sendType'] : null;
            $model->no_automatic_sending = isset($data['noAutomaticSending']) ? $data['noAutomaticSending'] : null;


            if (isset($data['image']) && strpos($data['image'], 'base64') !== false) {
                $model->image = FileUploader::uploadFile($data['image']);
            }
            $model->condition_id = isset($data['conditionId']) ? $data['conditionId'] : null;
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
                    $item['discount_deferred'] = isset($item['discountDeferred']) ? $item['discountDeferred'] : null;
                    $item['discount_on_cash'] = isset($item['discountOnCash']) ? $item['discountOnCash'] : null;
                    $item['minimum_per_family'] = isset($item['minimumPerFamily']) ? $item['minimumPerFamily'] : null;
                    $item['factory_price'] = isset($item['factoryPrice']) ? $item['factoryPrice'] : null;
                    $item['price_deferred'] = isset($item['priceDeferred']) ? $item['priceDeferred'] : null;
                    $item['price_on_cash'] = isset($item['priceOnCash']) ? $item['priceOnCash'] : null;
                    $item['quantity_maximum'] = isset($item['quantityMaximum']) ? $item['quantityMaximum'] : null;
                    $item['quantity_minimum'] = isset($item['quantityMinimum']) ? $item['quantityMinimum'] : null;
                    $item['state_id'] = $item['stateId'];
                    $item['product_id'] = $item['productId'];
                    $model->products()->create($item);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
