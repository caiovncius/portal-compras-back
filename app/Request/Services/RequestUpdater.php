<?php

namespace App\Request\Services;

use App\Request;
use App\Request\Contracts\RequestUpdatable;

class RequestUpdater implements RequestUpdatable
{
    /**
     * @param Request $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Request $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->pharmacy_id = $data['pharmacyId'];
            $model->offer_id = $data['offerId'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            if (isset($data['products'])) {
                $model->products()->detach();
                foreach ($data['products'] as $product) {
                    $model->products()->attach($product['productId'], ['qtd' => $product['quantity']]);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function cancel(Request $request)
    {
        try {
            $request->status = 'CANCELED';
            $request->save();

            $request->historics()->create([
                'user' => auth()->guard('api')->user()->name,
                'action' => 'Pedido cancelado',
                'status' => 'CANCELADO'
            ]);

            return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param string $status
     * @param int $returnId
     * @return bool
     * @throws \Exception
     */
    public function updateAllProductStatus(Request $request, string $status, int $returnId)
    {
        try {

            $request->products()->each(function ($product) use($status, $returnId) {
                $product->pivot->status = $status;
                $product->pivot->return_id = $returnId;

                if ($status === 'ATTENDED') {
                    $product->pivot->quantity_served = $product->pivot->requested_quantity;
                }

                $product->pivot->save();
            });

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param array $items
     * @return bool
     * @throws \Exception
     */
    public function massUpdateProductStatus(Request $request, array $items)
    {
        try {

            foreach ($items as $item) {

                $product = $request->products()->where('products.id', $item['productId'])->first();

                if (is_null($product)) continue;

                $product->pivot->status = $item['status'];
                $product->pivot->return_id = $item['returnId'];
                $product->pivot->quantity_served = $item['attendedQuantity'];
                $product->pivot->save();
            }

            return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
