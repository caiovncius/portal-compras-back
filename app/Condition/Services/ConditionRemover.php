<?php

namespace App\Condition\Services;

use App\Condition;
use App\Condition\Contracts\ConditionRemovable;
use App\ConditionPartner;

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
            $model->status = Condition::CONDITION_STATUS_INACTIVE;
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
