<?php


namespace App\Product\Services;

use App\Product;
use App\Product\Contracts\ProductCreatable;

class ProductCreator implements ProductCreatable
{
    /**
     * @param array $productData
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $productData)
    {
        try {
            $product = Product::create($productData);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
