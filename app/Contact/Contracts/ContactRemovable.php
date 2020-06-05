<?php

namespace App\Contact\Contracts;

use App\Contact;

interface ContactRemovable
{
    /**
     * @param Contact $data
     * @return bool
     * @throws \Exception
     */
    public function delete(Contact $data);
}
