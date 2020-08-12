<?php

namespace App\Purchase\Services;

use App\Purchase;
use App\Purchase\Contracts\PurchaseRemovable;

class PurchaseRemover implements PurchaseRemovable
{
    /**
     * @param Purchase $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Purchase $model)
    {
        try {
            $model->delete();

            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
