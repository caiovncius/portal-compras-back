<?php


namespace App\Laboratory\Services;

use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryCreatable;

class LaboratoryCreator implements LaboratoryCreatable
{
    /**
     * @param array $laboratoryData
     * @return bool
     * @throws \Exception
     */
    public function store(array $laboratoryData)
    {
        try {
            $Laboratory = Laboratory::create($laboratoryData);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
