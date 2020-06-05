<?php


namespace App\Contact\Services;

use App\Contact;
use App\Contact\Contracts\ContactCreatable;

class ContactCreator implements ContactCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Contact::create($data);

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
