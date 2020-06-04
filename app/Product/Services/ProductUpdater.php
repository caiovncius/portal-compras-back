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
            $product->fill($productData);
            $product->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
