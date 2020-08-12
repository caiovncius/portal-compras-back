<?php

namespace App\Offer\Contracts;

use App\Offer;

interface OfferProductCreatable
{
    /**
     * @param int $offer
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(Offer $offer, array $data);
}
