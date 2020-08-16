<?php

namespace App\Accompaniment\Services;

use App\Accompaniment;
use App\Accompaniment\Contracts\AccompanimentUpdatable;

class AccompanimentUpdater implements AccompanimentUpdatable
{
    /**
     * @param Accompaniment $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Accompaniment $model, array $data)
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
}
