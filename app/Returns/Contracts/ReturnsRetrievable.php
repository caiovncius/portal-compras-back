<?php

namespace App\Returns\Contracts;

interface ReturnsRetrievable
{
    public function getReturns(array $params = []);
}
