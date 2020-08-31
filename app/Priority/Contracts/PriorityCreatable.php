<?php

namespace App\Priority\Contracts;

interface PriorityCreatable
{
    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store(array $data);
}
