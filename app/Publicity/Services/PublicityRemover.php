<?php

namespace App\Publicity\Services;

use App\Publicity;
use App\Publicity\Contracts\PublicityRemovable;

class PublicityRemover implements PublicityRemovable
{
    /**
     * @param Publicity $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Publicity $model)
    {
        try {
            $model->delete();
            
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
