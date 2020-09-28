<?php

namespace App\Offer\Contracts;

use App\Offer;

interface OfferUpdatable
{
    /**
     * @param Offer $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public function update(Offer $data, array $newData);

    /**
     * @param Offer $offer
     * @return bool
     */
    public function enable(Offer $offer);
}
