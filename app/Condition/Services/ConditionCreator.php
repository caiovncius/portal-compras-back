<?php

namespace App\Condition\Services;

use App\Condition;
use App\Condition\Contracts\ConditionCreatable;

class ConditionCreator implements ConditionCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $model = Condition::create($data);
            
            if (isset($data['partners'])) {
                $model->partners()->delete();
                foreach ($data['partners'] as $data) {
                    $model->partners()->create($data);
                }
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
