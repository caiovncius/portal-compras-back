<?php

namespace App\Publicity\Services;

use App\Publicity;
use App\Publicity\Contracts\PublicityUpdatable;

class PublicityUpdater implements PublicityUpdatable
{
    /**
     * @param Publicity $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Publicity $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->user()->id;
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
