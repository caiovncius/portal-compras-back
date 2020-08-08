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
            $product = new Product();
            $product->code = $productData['code'];
            $product->code_ean = $productData['codeEan'];
            $product->description = $productData['description'];
            $product->laboratory_id = $productData['laboratoryId'];
            $product->updated_id = auth()->guard('api')->user()->id;
            $product->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
