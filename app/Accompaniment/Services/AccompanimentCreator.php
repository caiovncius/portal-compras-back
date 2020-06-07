<?php

namespace App\Accompaniment\Services;

use App\Accompaniment;
use App\Accompaniment\Contracts\AccompanimentCreatable;

class AccompanimentCreator implements AccompanimentCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Accompaniment::create($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
