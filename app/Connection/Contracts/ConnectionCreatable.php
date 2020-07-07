<?php

namespace App\Connection\Contracts;

interface ConnectionCreatable
{
    /**
     * @param $model
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store($model, array $data);
}
