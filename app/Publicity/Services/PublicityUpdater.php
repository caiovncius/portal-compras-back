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
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->date_create = $data['createDate'];
            $model->date_publish = $data['publishDate'];
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
