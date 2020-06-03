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
            $laboratory->delete();
            
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
