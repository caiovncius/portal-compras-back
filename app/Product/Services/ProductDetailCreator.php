<?php

namespace App\Product\Services;

use App\Product\Contracts\ProductDetailCreatable;

class ProductDetailCreator implements ProductDetailCreatable
{
    /**
     * @param int $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store($model, array $data)
    {
        try {
            if (isset($data['products'])) {
                $model->products()->delete();
                foreach ($data['products'] as $item) {
                    $model->products()->create($item);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
