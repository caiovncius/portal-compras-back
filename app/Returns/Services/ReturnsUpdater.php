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
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Returns $returns
     * @return bool
     */
    public function enable(Returns $returns)
    {
        $returns->status = Returns::RETURN_STATUS_ACTIVE;
        $returns->save();
        return true;
    }
}
