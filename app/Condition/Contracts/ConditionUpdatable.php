<?php

namespace App\Condition\Contracts;

use App\Condition;

interface ConditionUpdatable
{
    /**
     * @param Condition $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Condition $data, array $newData);
}
