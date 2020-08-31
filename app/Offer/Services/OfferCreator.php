<?php


namespace App\Offer\Services;

use App\Helpers\FileUploader;
use App\Offer;
use App\Offer\Contracts\OfferCreatable;

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

            if (isset($data['partners'])) {
                foreach ($data['partners'] as $partner) {
                    $model->partners()->attach($partner['id'], [
                        'type' => $partner['type'],
                        'ol' => $partner['ol'],
                        'priority' => $partner['priority'],
                    ]);
                }
            }

            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $item['discount_deferred'] = $item['discountDeferred'];
                    $item['discount_on_cash'] = $item['discountOnCash'];
                    $item['minimum_per_family'] = $item['minimumPerFamily'];
                    $item['factory_price'] = $item['factoryPrice'];
                    $item['price_deferred'] = $item['priceDeferred'];
                    $item['price_on_cash'] = $item['PriceOnCash'];
                    $item['quantity_maximum'] = $item['quantityMaximum'];
                    $item['quantity_minimum'] = $item['quantityMinimum'];
                    $model->products()->create($item);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
