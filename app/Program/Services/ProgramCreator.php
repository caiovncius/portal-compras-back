<?php


namespace App\Program\Services;

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
            $model = Program::create($data);
            
            if (isset($data['contacts'])) {
                foreach ($data['contacts'] as $data) {
                    $model->contacts()->create($data);
                }
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
