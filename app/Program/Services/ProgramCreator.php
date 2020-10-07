<?php


namespace App\Program\Services;

use App\Connection\Contracts\ConnectionCreatable;
use App\Program;
use App\Program\Contracts\ProgramCreatable;

class ProgramCreator implements ProgramCreatable
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
            $model = Program::create($data);

            if (isset($data['contacts'])) {
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
                $connectionService = app()->make(ConnectionCreatable::class);
                $connectionService->store($model, $data['connection']);
            }

            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
