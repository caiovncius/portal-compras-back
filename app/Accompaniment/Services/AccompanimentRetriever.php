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

            if (isset($params['codeOrder']) && !empty($params['codeOrder'])) {
                $query->where('code_order', $params['codeOrder']);
            }

            if (isset($params['codePharmacy']) && !empty($params['codePharmacy'])) {
                $query->where('code_pharmacy', $params['codePharmacy']);
            }

            if (isset($params['createDate']) && !empty($params['createDate'])) {
                $query->where('date_create', $params['createDate']);
            }

            if (isset($params['publishDate']) && !empty($params['publishDate'])) {
                $query->where('date_publish', $params['publishDate']);
            }

            if (isset($params['commercial']) && !empty($params['commercial'])) {
                $query->where('commercial', $params['commercial']);
            }

            if (isset($params['sendType']) && !empty($params['sendType'])) {
                $query->where('type_send', $params['sendType']);
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
