<?php

namespace App\Distributor\Services;

use App\Contact;
use App\Distributor;
use App\Distributor\Contracts\DistributorCreatable;

class DistributorCreator implements DistributorCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Distributor::create($data);

            if (isset($data['contacts'])) {
                foreach ($data['contacts'] as $data) {
                    $model->contacts()->create($data);
                }
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
