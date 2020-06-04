<?php


namespace App\Laboratory\Contracts;


use App\Laboratory;

interface LaboratoryRemovable
{

    /**
     * @param Laboratory $laboratory
     * @return bool
     * @throws \Exception
     */
    public function delete(Laboratory $laboratory);
}
