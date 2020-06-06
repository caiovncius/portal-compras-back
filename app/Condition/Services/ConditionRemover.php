<?php

namespace App\Condition\Services;

use App\Condition;
use App\Condition\Contracts\ConditionRemovable;

class ConditionRemover implements ConditionRemovable
{
    /**
     * @param Condition $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Condition $model)
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
