<?php

namespace App\Program\Contracts;

use App\Program;

interface ProgramRetrievable
{
    public function getPrograms(array $params = []);

    /**
     * @param Program $program
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * @throws \Exception
     */
    public function getReturnsByProgram(\App\Program $program);
}
