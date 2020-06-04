<?php


namespace App\Laboratory\Contracts;


use App\Laboratory;

interface LaboratoryUpdatable
{
    /**
     * @param Laboratory $laboratory
     * @param array $laboratoryData
     * @return bool
     * @throws \Exception
     */
    public function update(Laboratory $laboratory, array $laboratoryData);
}
