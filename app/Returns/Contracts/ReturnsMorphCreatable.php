<?php

namespace App\Returns\Contracts;

interface ReturnsMorphCreatable
{
    /**
     * @param int $model
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function returns($model, array $data);
}
