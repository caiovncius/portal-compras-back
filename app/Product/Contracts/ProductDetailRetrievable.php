<?php

namespace App\Product\Contracts;

interface ProductDetailRetrievable
{
    public function getProducts($model, array $params = []);
}
