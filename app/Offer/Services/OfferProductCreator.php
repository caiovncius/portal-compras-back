<?php

namespace App\Offer\Services;

use App\Offer;
use App\Offer\Contracts\OfferProductCreatable;

class OfferProductCreator implements OfferProductCreatable
{
    /**
     * @param Offer $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store(Offer $model, array $data)
    {
        try {
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
