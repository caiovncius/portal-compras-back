<?php

namespace App\Offer\Services;

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
            $model->save();

            if (isset($data['partners'])) {
                $model->partners()->detach();
                foreach ($data['partners'] as $data) {
                    $model->partners()->attach($data, ['type' => $data['type']]);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
