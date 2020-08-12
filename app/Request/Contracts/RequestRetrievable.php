<?php

namespace App\Request\Contracts;

interface RequestRetrievable
{
    public function getRequests(array $params = []);
}
