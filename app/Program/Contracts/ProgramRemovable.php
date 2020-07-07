<?php

namespace App\Program\Contracts;

use App\Program;

interface ProgramRemovable
{
    /**
     * @param Program $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Program $data);
}
