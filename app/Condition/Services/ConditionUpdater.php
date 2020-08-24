<?php

namespace App\Condition\Services;

use App\Contact;
use App\Condition;
use App\Condition\Contracts\ConditionUpdatable;

class ConditionUpdater implements ConditionUpdatable
{
    /**
     * @param Condition $model
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function update(Condition $model, array $data)
    {
        try {
            $model->fill($data);
            $model->updated_id = auth()->guard('api')->user()->id;
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            
            if (isset($data['partners'])) {
                $model->partners()->delete();
                foreach ($data['partners'] as $data) {
                    $model->partners()->create($data);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
