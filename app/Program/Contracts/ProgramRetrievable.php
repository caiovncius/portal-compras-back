<?php

namespace App\Program\Contracts;

interface ProgramRetrievable
{
    public function getPrograms(array $params = []);
}
