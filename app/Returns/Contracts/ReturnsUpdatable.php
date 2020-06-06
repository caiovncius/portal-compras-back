<?php

namespace App\Returns\Contracts;

use App\Returns;

interface ReturnsUpdatable
{
    /**
     * @param Returns $data
     * @param array $newData
     * @Returns bool
     * @throws \Exception
     */
    public  function update(Returns $data, array $newData);
}
