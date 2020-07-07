<?php

namespace App\Offer\Contracts;

interface OfferCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
