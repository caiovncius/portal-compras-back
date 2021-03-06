<?php

namespace App\Returns\Services;

use App\Returns;
use App\Returns\Contracts\ReturnsRemovable;

class ReturnsRemover implements ReturnsRemovable
{
    /**
     * @param Returns $model
     * @Returns bool
     * @throws \Exception
     */
    public function delete(Returns $model)
    {
        try {
            $model->status = Returns::RETURN_STATUS_INACTIVE;
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
