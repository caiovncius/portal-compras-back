<?php

namespace App\Accompaniment\Contracts;

use App\Accompaniment;

interface AccompanimentUpdatable
{
    /**
     * @param Accompaniment $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Accompaniment $data, array $newData);
}
