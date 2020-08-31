<?php

namespace App\Offer\Services;

use App\Helpers\FileUploader;
use App\Offer;
use App\Offer\Contracts\OfferUpdatable;

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
            $model->updated_at = date('Y-m-d H:i:s');
            $model->start_date = $data['startDate'];
            $model->end_date = $data['endDate'];
            $model->minimum_price = $data['minimumPrice'];
            $model->offer_type = $data['offerType'];
            $model->send_type = $data['sendType'];
            $model->no_automatic_sending = $data['noAutomaticSending'];
            
            if (strpos($data['image'], 'base64') !== false) {
                $model->image = FileUploader::uploadFile($data['image']);
            }
            $model->condition_id = $data['condition'];
            $model->save();

            if (isset($data['partners'])) {
                $model->partners()->detach();
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
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
