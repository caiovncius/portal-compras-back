<?php

namespace App\Product\Contracts;

interface ProductDetailCreatable
{
    /**
     * @param int $model
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store($model, array $data);
}
