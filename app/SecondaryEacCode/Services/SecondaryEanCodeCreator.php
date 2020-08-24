<?php

namespace App\SecondaryEacCode\Services;

use App\Product;
use App\SecondaryEacCode\Contracts\SecondaryEanCodeCreatorable;
use App\SecondaryEanCode;

class SecondaryEanCodeCreator implements SecondaryEanCodeCreatorable
{
    /**
     * @param Product $product
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function create(Product $product, array $data)
    {
        try {
            SecondaryEanCode::create([
                'product_id' => $product->id,
                'name' => $data['name']
            ]);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
