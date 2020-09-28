<?php

namespace App\Product\Services;

use App\Product;
use App\Product\Contracts\ProductRemovable;

class ProductRemover implements ProductRemovable
{
    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product)
    {
        try {
            $product->status = Product::PRODUCT_STATUS_INACTIVE;
            $product->save();
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
