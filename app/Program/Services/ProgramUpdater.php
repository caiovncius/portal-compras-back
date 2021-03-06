<?php

namespace App\Program\Services;

use App\Connection\Contracts\ConnectionCreatable;
use App\Connection\Contracts\ConnectionUpdatable;
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
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();

            if (isset($data['contacts'])) {
                $model->contacts()->delete();
                foreach ($data['contacts'] as $data) {
                    $model->contacts()->create($data);
                }
            }

            if (isset($data['returns'])) {
                $model->returns()->delete();
                foreach ($data['returns'] as $data) {
                    $model->returns()->create($data);
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

            return $model;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Program $program
     * @return bool
     */
    public function enable(Program $program)
    {
        $program->status = Program::PROGRAM_STATUS_ACTIVE;
        $program->save();
        return true;
    }
}
