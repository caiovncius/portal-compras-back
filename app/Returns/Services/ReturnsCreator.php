<?php

namespace App\Returns\Services;

use App\Returns;
use App\Returns\Contracts\ReturnsCreatable;

class ReturnsCreator implements ReturnsCreatable
{
    /**
     * @param array $data
     * @Returns bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Returns::create($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
