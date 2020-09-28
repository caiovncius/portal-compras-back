<?php

namespace App\Offer\Services;

use App\Offer;
use App\Offer\Contracts\OfferRemovable;

class OfferRemover implements OfferRemovable
{
    /**
     * @param Offer $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Offer $model)
    {
        try {
            $model->status = Offer::OFFER_STATUS_INACTIVE;
            $model->save();
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
