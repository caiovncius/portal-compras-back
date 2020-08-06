<?php


namespace App\Product\Services;


use App\Product;
use App\Product\Contracts\ProductUpdatable;

class ProductUpdater implements ProductUpdatable
{
    /**
     * @param Product $product
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public function update(Product $product, array $productData)
    {
        try {
            $product->code = $productData['code'];
            $product->code_ean = $productData['codeEan'];
            $product->description = $productData['description'];
            $product->laboratory_id = $productData['laboratoryId'];
            $product->updated_id = auth()->user()->id;
            $product->save();

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
