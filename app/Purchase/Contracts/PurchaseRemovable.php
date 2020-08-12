<?php

namespace App\Purchase\Contracts;

use App\Purchase;

interface PurchaseRemovable
{
    /**
     * @param Purchase $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Purchase $data);
}
