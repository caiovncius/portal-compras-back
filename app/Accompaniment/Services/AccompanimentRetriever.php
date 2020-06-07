<?php

namespace App\Accompaniment\Services;

use App\Accompaniment;
use App\Accompaniment\Contracts\AccompanimentRetrievable;

class AccompanimentRetriever implements AccompanimentRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getAccompaniments(array $params = [])
    {
        try {
            $query = Accompaniment::query();

            if (isset($params['code_order']) && !empty($params['code_order'])) {
                $query->where('code_order', $params['code_order']);
            }

            if (isset($params['code_pharmacy']) && !empty($params['code_pharmacy'])) {
                $query->where('code_pharmacy', $params['code_pharmacy']);
            }

            if (isset($params['date_create']) && !empty($params['date_create'])) {
                $query->where('date_create', $params['date_create']);
            }

            if (isset($params['date_publish']) && !empty($params['date_publish'])) {
                $query->where('date_publish', $params['date_publish']);
            }

            if (isset($params['commercial']) && !empty($params['commercial'])) {
                $query->where('commercial', $params['commercial']);
            }

            if (isset($params['type_send']) && !empty($params['type_send'])) {
                $query->where('type_send', $params['type_send']);
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            if (isset($params['createdAt']) && !empty($params['createdAt'])) {
                $query->where('created_at', '>=', $params['created_at']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
