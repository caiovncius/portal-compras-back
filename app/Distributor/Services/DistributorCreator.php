<?php

namespace App\Distributor\Services;

use App\Connection\Contracts\ConnectionCreatable;
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
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $data['state_id'] = $data['stateId'];
            $model = Distributor::create($data);

            if (isset($data['contacts'])) {
                foreach ($data['contacts'] as $contact) {
                    $model->contacts()->create($contact);
                }
            }

            if (isset($data['returns'])) {
                foreach ($data['returns'] as $return) {
                    $model->returns()->create($return);
                }
            }

            if (isset($data['connection'])) {
                $connectionService = app()->make(ConnectionCreatable::class);
                $connectionService->store($model, $data['connection']);
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
