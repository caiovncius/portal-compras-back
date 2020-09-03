<?php

namespace App\Request\Services;

use App\Request;
use App\Request\Contracts\RequestProductUpdatable;

class RequestProductUpdater implements RequestProductUpdatable
{
    /**
     * @param Request $model
     * @param integer $product
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Request $model, $product = '', array $data)
    {
        try {
            if ($product) {
                $model = $model->products->find($product);
                $model->pivot->status = $data['status'];
                $model->pivot->return_id = $data['returnId'];
                $model->pivot->qtd_return = isset($data['qtdReturn']) ? $data['qtdReturn'] : $model->pivot->qtd_return;
                $model->pivot->save();
            } else {
                foreach($model->products as $model) {
                    $model->pivot->status = $data['status'];
                    $model->pivot->return_id = $data['returnId'];
                    $model->pivot->save();
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
