<?php

namespace App\Product\Contracts;

interface ProductDetailRetrievable
{
    public function getProducts(array $params = []);
}
