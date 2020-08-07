<?php

namespace App\Returns\Services;

use App\Returns;
use App\Returns\Contracts\ReturnsUpdatable;

class ReturnsUpdater implements ReturnsUpdatable
{
    /**
     * @param Returns $model
     * @param array $data
     * @Returns bool
     * @throws \Exception
     */
    public function update(Returns $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
