<?php

namespace App\Request\Services;

use App\Request;
use App\Request\Contracts\RequestRemovable;

class RequestRemover implements RequestRemovable
{
    /**
     * @param Request $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Request $model)
    {
        try {
            $model->products()->detach();
            $model->historics()->delete();
            $model->delete();

            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
