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

            $data['condition_id'] = $data['condition'];
            $model = Offer::create($data);

            if (isset($data['partners'])) {
                foreach ($data['partners'] as $data) {
                    $model->partners()->attach($data['id'], [
                        'type' => $data['type'],
                        'ol' => $data['ol'],
                        'priority' => $data['priority'],
                    ]);
                }
            }

            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $item['discount_deferred'] = isset($item['discountDeferred']) ? $item['discountDeferred'] : null;
                    $item['discount_on_cash'] = isset($item['discountOnCash']) ? $item['discount_on_cash'] : null;
                    $item['minimum_per_family'] = isset($item['minimumPerFamily']) ? $item['minimum_per_family'] : null;
                    $item['factory_price'] = isset($item['factoryPrice']) ? $item['factoryPrice'] : null;
                    $item['price_deferred'] = isset($item['priceDeferred']) ? $item['priceDeferred'] : null;
                    $item['price_on_cash'] = isset($item['PriceOnCash']) ? $item['PriceOnCash'] : null;
                    $item['quantity_maximum'] = isset($item['quantityMaximum']) ? $item['quantityMaximum'] : null;
                    $item['quantity_minimum'] = isset($item['quantityMinimum']) ? $item['quantityMinimum'] : null;
                    $model->products()->create($item);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
