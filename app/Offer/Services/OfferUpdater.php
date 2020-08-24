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
                    $model->products()->create($item);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
