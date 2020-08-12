<?php


namespace App\Laboratory\Services;

use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryCreatable;

class LaboratoryCreator implements LaboratoryCreatable
{
    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $Laboratory = Laboratory::create($data);

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
