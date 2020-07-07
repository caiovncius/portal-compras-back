<?php

namespace App\Offer\Contracts;

interface OfferRetrievable
{
    public function getOffers(array $params = []);
}
