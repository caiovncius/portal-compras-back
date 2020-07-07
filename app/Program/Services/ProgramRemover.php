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
            $model->contacts()->delete();
            $model->delete();
            
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
