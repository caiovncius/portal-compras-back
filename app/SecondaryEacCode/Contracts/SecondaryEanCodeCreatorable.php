<?php

namespace App\SecondaryEacCode\Contracts;

use App\Product;
use App\SecondaryEanCode;

interface SecondaryEanCodeCreatorable
{
    /**
     * @param Product $product
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function create(Product $product, array $data);
}
