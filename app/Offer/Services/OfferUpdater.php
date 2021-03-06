<?php

namespace App\Offer\Services;

use App\Distributor;
use App\Helpers\FileUploader;
use App\Offer;
use App\Partner;
use App\Offer\Contracts\OfferUpdatable;
use App\ProductDetail;
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
            $model->minimum_family = isset($data['minimumPerFamily']) ? $data['minimumPerFamily'] : null;


            if (isset($data['image']) && strpos($data['image'], 'base64') !== false) {
                $model->image = FileUploader::uploadFile($data['image']);
            }

            $model->condition_id = isset($data['condition']) ? $data['condition'] : null;
            $model->save();
            $model->partners()->delete();

            if ($data['sendType'] === 'AUTOMATIC' && isset($data['partners']) && !empty($data['partners'])) {
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
            }

            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {

                    $factoryPrice = isset($item['factoryPrice']) ? $item['factoryPrice'] : null;
                    $discountOnCash = isset($item['discountOnCash']) ? $item['discountOnCash'] : null;
                    $discountDeferred = isset($item['discountDeferred']) ? $item['discountDeferred'] : null;

                    $item['discount_deferred'] = $discountDeferred;
                    $item['discount_on_cash'] = $discountOnCash;
                    $item['minimum_per_family'] = null;
                    $item['factory_price'] = $factoryPrice;
                    $item['price_deferred'] = ProductDetail::sumDiscount($factoryPrice, $discountDeferred);
                    $item['price_on_cash'] = ProductDetail::sumDiscount($factoryPrice, $discountOnCash);
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

    /**
     * @param Offer $offer
     * @return bool
     */
    public function enable(Offer $offer)
    {
        $offer->status = Offer::OFFER_STATUS_ACTIVE;
        $offer->save();
        return true;
    }
}
