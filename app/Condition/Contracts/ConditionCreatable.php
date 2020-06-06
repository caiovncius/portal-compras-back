<?php

namespace App\Condition\Contracts;

interface ConditionCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data);
}
