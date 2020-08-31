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
            $data['start_date'] = $data['start_date'];
            $data['end_date'] = $data['end_date'];
            $data['minimum_price'] = $data['minimumPrice'];
            $data['offer_type'] = $data['offerType'];
            $data['send_type'] = $data['sendType'];
            $data['no_automatic_sending'] = $data['noAutomaticSending'];

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
                    $model->products()->create($item);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
