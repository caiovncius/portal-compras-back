<?php

namespace App\Condition\Services;

use App\Condition;
use App\Condition\Contracts\ConditionCreatable;

class ConditionCreator implements ConditionCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Condition::create($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
