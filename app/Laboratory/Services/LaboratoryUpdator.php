<?php


namespace App\Laboratory\Services;


use App\Functionality;
use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryUpdatable;

class LaboratoryUpdator implements LaboratoryUpdatable
{
    /**
     * @param Laboratory $laboratory
     * @param array $laboratoryData
     * @return bool
     * @throws \Exception
     */
    public function update(Laboratory $model, array $laboratoryData)
    {
        try {
            $model->fill($laboratoryData);
            $model->updated_id = auth()->guard('api')->user()->id;
            $laboratory->save();

            return true;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
