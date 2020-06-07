<?php

namespace App\Publicity\Contracts;

interface PublicityRetrievable
{
    public function getPublicities(array $params = []);
}
