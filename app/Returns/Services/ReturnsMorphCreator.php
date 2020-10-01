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

            $collection = collect($data['returns']);
            $uniques = $collection->unique('code');
            foreach ($uniques->toArray() as $return) {
                $model->returns()->create($return);
            }
        }

        return true;
    }
}
