<?php


namespace App\Offer\Services;

use App\Distributor;
use App\Helpers\FileUploader;
use App\Offer;
use App\Partner;
use App\Offer\Contracts\OfferCreatable;
use App\ProductDetail;
use App\Program;

class OfferCreator implements OfferCreatable
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
            $data['start_date'] = isset($data['startDate']) ? $data['startDate'] : null;
            $data['end_date'] = isset($data['endDate']) ? $data['endDate'] : null;
            $data['minimum_price'] = isset($data['minimumPrice']) ? $data['minimumPrice'] : null;
            $data['offer_type'] = isset($data['offerType']) ? $data['offerType'] : null;
            $data['send_type'] = isset($data['sendType']) ? $data['sendType'] : null;
            $data['no_automatic_sending'] = isset($data['noAutomaticSending']) ? $data['noAutomaticSending'] : null;

            if (isset($data['image']) && strpos($data['image'], 'base64') !== false) {
                $data['image'] = FileUploader::uploadFile($data['image']);
            }

            $data['condition_id'] = isset($data['conditionId']) ? $data['conditionId'] : null;
            $model = Offer::create($data);

            if (isset($data['partners']) && !empty($data['partners'])) {
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
                foreach ($data['products'] as $item) {

                    $factoryPrice = isset($item['factoryPrice']) ? $item['factoryPrice'] : 0;
                    $discountOnCash = isset($item['discountOnCash']) ? $item['discountOnCash'] : 0;
                    $discountDeferred = isset($item['discountDeferred']) ? $item['discountDeferred'] : 0;

                    $item['discount_deferred'] = $discountDeferred;
                    $item['discount_on_cash'] = $discountOnCash;
                    $item['minimum_per_family'] = isset($item['minimumPerFamily']) ? $item['minimumPerFamily'] : 0;
                    $item['factory_price'] = $factoryPrice;
                    $item['price_deferred'] = ProductDetail::sumDiscount($factoryPrice, $discountDeferred);
                    $item['price_on_cash'] = ProductDetail::sumDiscount($factoryPrice, $discountOnCash);
                    $item['quantity_maximum'] = isset($item['quantityMaximum']) ? $item['quantityMaximum'] : 0;
                    $item['quantity_minimum'] = isset($item['quantityMinimum']) ? $item['quantityMinimum'] : 0;
                    $item['state_id'] = $item['stateId'];
                    $item['product_id'] = $item['productId'];
                    $model->products()->create($item);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
