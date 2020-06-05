<?php

namespace App\Contact\Services;

use App\Contact;
use App\Contact\Contracts\ContactUpdatable;

class ContactUpdater implements ContactUpdatable
{
    /**
     * @param Contact $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Contact $model, array $data)
    {
        try {
            $model->fill($data);
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
