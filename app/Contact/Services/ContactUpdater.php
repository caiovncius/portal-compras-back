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
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
