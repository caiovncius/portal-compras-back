<?php


namespace App\Laboratory\Contracts;


interface LaboratoryCreatable
{
    /**
     * @param array $laboratoryData
     * @return bool
     * @throws \Exception
     */
    public function store(array $laboratoryData);
}
