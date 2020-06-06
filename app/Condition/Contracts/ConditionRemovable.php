<?php

namespace App\Condition\Contracts;

use App\Condition;

interface ConditionRemovable
{
    /**
     * @param Condition $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Condition $data);
}
