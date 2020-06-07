<?php

namespace App\Publicity\Services;

use App\Publicity;
use App\Publicity\Contracts\PublicityCreatable;

class PublicityCreator implements PublicityCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Publicity::create($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
