<?php

namespace App\Request\Contracts;

use App\Request;

interface RequestRemovable
{
    /**
     * @param Request $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Request $data);
}
