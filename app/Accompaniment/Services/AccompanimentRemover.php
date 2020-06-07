<?php

namespace App\Accompaniment\Services;

use App\Accompaniment;
use App\Accompaniment\Contracts\AccompanimentRemovable;

class AccompanimentRemover implements AccompanimentRemovable
{
    /**
     * @param Accompaniment $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Accompaniment $model)
    {
        try {
            $model->dettach();
            $model->delete();
            
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
