<?php


namespace App\Product\Contracts;


use App\Product;

interface ProductRemovable
{
    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product);
}
