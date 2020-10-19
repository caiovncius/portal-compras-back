<?php

namespace App\Distributor\Services;

use App\Connection\Contracts\ConnectionCreatable;
use App\Connection\Contracts\ConnectionUpdatable;
use App\Contact;
use App\Distributor;
use App\Distributor\Contracts\DistributorUpdatable;

class DistributorUpdater implements DistributorUpdatable
{
    /**
     * @param Distributor $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Distributor $model, array $data)
    {
        try {
            $data['state_id'] = $data['stateId'];

            if ($model->code === $data['code']) {
                unset($data['code']);
            }

            if ($model->cnpj === $data['cnpj']) {
                unset($data['cnpj']);
            }

            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            if (isset($data['contacts'])) {
                $model->contacts()->delete();
                foreach ($data['contacts'] as $contact) {
                    $model->contacts()->create($contact);
                }
            }

            if (isset($data['returns'])) {
                $model->returns()->delete();
                foreach ($data['returns'] as $return) {
                    $model->returns()->create($return);
                }
            }

            if (isset($data['connection'])) {
                if (is_null($model->connection)) {
                    $connectionService = app()->make(ConnectionCreatable::class);
                    $connectionService->store($model, $data['connection']);
                } else {
                    $connectionService = app()->make(ConnectionUpdatable::class);
                    $connectionService->update($model, $data['connection']);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Distributor $distributor
     * @return bool
     */
    public function enable(Distributor $distributor)
    {
        $distributor->status = Distributor::DISTRIBUTOR_STATUS_ACTIVE;
        $distributor->save();
        return true;
    }
}
