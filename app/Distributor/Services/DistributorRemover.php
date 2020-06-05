<?php

namespace App\Distributor\Services;

use App\Distributor;
use App\Distributor\Contracts\DistributorRemovable;

class DistributorRemover implements DistributorRemovable
{
    /**
     * @param Distributor $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Distributor $model)
    {
        try {
            $model->dettach();
            $model->delete();
            
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
