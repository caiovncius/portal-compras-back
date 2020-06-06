<?php

namespace App\Condition\Contracts;

interface ConditionRetrievable
{
    public function getConditions(array $params = []);
}
