<?php

namespace App\Program\Services;

use App\Program;
use App\Program\Contracts\ProgramUpdatable;

class ProgramUpdater implements ProgramUpdatable
{
    /**
     * @param Program $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Program $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->save();

            if (isset($data['contacts'])) {
                $model->contacts()->delete();
                foreach ($data['contacts'] as $data) {
                    $model->contacts()->create($data);
                }
            }
            
            return $model;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
