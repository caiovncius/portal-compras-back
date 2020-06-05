<?php

namespace App\Contact\Services;

use App\Contact;
use App\Contact\Contracts\ContactRemovable;

class ContactRemover implements ContactRemovable
{
    /**
     * @param Contact $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Contact $model)
    {
        try {
            $model->delete();
            
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
