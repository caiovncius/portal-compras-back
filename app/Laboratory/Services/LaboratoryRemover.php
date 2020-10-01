<?php


namespace App\Laboratory\Services;


use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryRemovable;

class LaboratoryRemover implements LaboratoryRemovable
{

    /**
     * @param Laboratory $laboratory
     * @return bool
     * @throws \Exception
     */
    public function delete(Laboratory $laboratory)
    {
        try {
            $laboratory->status = Laboratory::LABORATORY_STATUS_INACTIVE;
            $laboratory->save();

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
