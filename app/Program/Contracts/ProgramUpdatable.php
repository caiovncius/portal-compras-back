<?php

namespace App\Program\Contracts;

use App\Program;

interface ProgramUpdatable
{
    /**
     * @param Program $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public function update(Program $data, array $newData);

    /**
     * @param Program $program
     * @return bool
     */
    public function enable(Program $program);
}
