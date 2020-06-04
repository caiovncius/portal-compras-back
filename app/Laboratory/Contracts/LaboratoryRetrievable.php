<?php


namespace App\Laboratory\Contracts;


use App\Laboratory;

interface LaboratoryRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function laboratories(array $params);
}
