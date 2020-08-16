<?php


namespace App\Product\Services;


use App\Product;
use App\Product\Contracts\ProductUpdatable;

class ProductUpdater implements ProductUpdatable
{
    /**
     * @param Product $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Product $model, array $data)
    {
        try {
            $model->code = $data['code'];
            $model->code_ean = $data['codeEan'];
            $model->description = $data['description'];
            $model->laboratory_id = $data['laboratoryId'];
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
