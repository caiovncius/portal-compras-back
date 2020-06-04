<?php


namespace App\Product\Services;


use App\Product;
use App\Product\Contracts\ProductRetrievable;

class ProductRetriever implements ProductRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getProducts(array $params = [])
    {
        try {
            $query = Product::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['code_ean']) && !empty($params['code_ean'])) {
                $query->where('code_ean', $params['code_ean']);
            }

            if (isset($params['description']) && !empty($params['description'])) {
                $query->where('description', 'like', '%' . $params['description'] . '%');
            }

            if (isset($params['createdAt']) && !empty($params['createdAt'])) {
                $query->where('created_at', '>=', $params['created_at']);
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['laboratory_id']) && !empty($params['laboratory_id'])) {
                $query->where('laboratory_id', $params['laboratory_id']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
