<?php

namespace App\Program\Services;

use App\Program;
use App\Program\Contracts\ProgramRemovable;

class ProgramRemover implements ProgramRemovable
{
    /**
     * @param Program $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Program $model)
    {
        try {
            $model->status = Program::PROGRAM_STATUS_INACTIVE;
            $model->save();

            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
