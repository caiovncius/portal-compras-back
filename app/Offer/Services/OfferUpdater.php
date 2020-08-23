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
            $model->image = FileUploader::uploadFile($data['image']);
            $model->condition_id = $data['condition'];
            $model->save();

            if (isset($data['partners'])) {
                $model->partners()->detach();
                foreach ($data['partners'] as $data) {
                    $model->partners()->attach($data['id'], ['type' => $data['type']]);
                }
            }

            if (isset($data['products'])) {
                $model->products()->detach();
                foreach ($data['products'] as $data) {
                    $model->products()->attach($data['id'], ['type' => $data['type']]);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
