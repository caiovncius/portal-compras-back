<?php


namespace App\Product\Contracts;


interface ProductCreatable
{
    /**
     * @param array $productData
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $productData);
}
