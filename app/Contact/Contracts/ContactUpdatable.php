<?php

namespace App\Contact\Contracts;

use App\Contact;

interface ContactUpdatable
{
    /**
     * @param Contact $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public function update(Contact $data, array $newData);
}
