<?php

namespace App\Distributor\Services;

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
            $model->fill($data);
            $model->save();

            if (isset($data['contacts'])) {
                foreach ($data['contacts'] as $data) {
                    $data['distributor_id'] = $model->id;
                    Contact::create($data);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
