<?php

namespace App\Contact\Contracts;

interface ContactRetrievable
{
    public function getContacts(array $params = []);
}
