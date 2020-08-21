<?php

namespace App\Offer\Contracts;

use App\Offer;

interface OfferProductRetrievable
{
    public function getProducts(Offer $model, array $params = []);
}
