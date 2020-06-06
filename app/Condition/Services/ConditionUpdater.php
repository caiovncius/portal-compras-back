<?php

namespace App\Condition\Services;

use App\Contact;
use App\Condition;
use App\Condition\Contracts\ConditionUpdatable;

class ConditionUpdater implements ConditionUpdatable
{
    /**
     * @param Condition $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Condition $model, array $data)
    {
        try {
            $model->fill($data);
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
