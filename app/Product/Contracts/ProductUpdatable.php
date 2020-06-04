<?php


namespace App\Product\Contracts;


use App\Product;

interface ProductUpdatable
{
    /**
     * @param Product $product
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Product $product, array $newData);
}
