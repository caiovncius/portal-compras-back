<?php

namespace App\Returns\Contracts;

use App\Returns;

interface ReturnsRemovable
{
    /**
     * @param Returns $data
     * @Returns bool
     * @throws \Exception
     */
    public function delete(Returns $data);
}
