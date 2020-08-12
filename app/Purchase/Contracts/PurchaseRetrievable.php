<?php

namespace App\Purchase\Contracts;

interface PurchaseRetrievable
{
    public function getPurchases(array $params = []);
}
