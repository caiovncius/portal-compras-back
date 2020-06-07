<?php

namespace App\Publicity\Contracts;

use App\Publicity;

interface PublicityRemovable
{
    /**
     * @param Publicity $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Publicity $data);
}
