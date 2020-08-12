<?php

namespace App\Purchase\Contracts;

use App\Purchase;

interface PurchaseUpdatable
{
    /**
     * @param Purchase $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Purchase $data, array $newData);
}
