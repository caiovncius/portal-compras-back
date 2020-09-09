<?php

namespace App\Returns\Services;

use App\Returns;
use App\Returns\Contracts\ReturnsMorphCreatable;

class ReturnsMorphCreator implements ReturnsMorphCreatable
{
    /**
     * @param integer $model
     * @param array $data
     */
    public function returns($model, array $data)
    {
        if (isset($data['returns'])) {
            $model->returns()->delete();
            foreach ($data['returns'] as $data) {
                if (isset($data['description'])) {
                    $data['desc'] = $data['description'];
                    unset($data['description']);
                }
                
                $model->returns()->create($data);
            }
        }

        return true;
    }
}
