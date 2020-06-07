<?php

namespace App\Accompaniment\Contracts;

use App\Accompaniment;

interface AccompanimentRemovable
{
    /**
     * @param Accompaniment $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Accompaniment $data);
}
