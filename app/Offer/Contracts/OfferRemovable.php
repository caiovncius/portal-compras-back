<?php

namespace App\Offer\Contracts;

use App\Offer;

interface OfferRemovable
{
    /**
     * @param Offer $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Offer $data);
}
