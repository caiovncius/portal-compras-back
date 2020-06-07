<?php

namespace App\Publicity\Contracts;

use App\Publicity;

interface PublicityUpdatable
{
    /**
     * @param Publicity $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Publicity $data, array $newData);
}
