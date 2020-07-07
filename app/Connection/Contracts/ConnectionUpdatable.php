<?php

namespace App\Connection\Contracts;

interface ConnectionUpdatable
{
    /**
     * @param $model
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update($model, array $newData);
}
