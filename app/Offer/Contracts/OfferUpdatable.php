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
}
