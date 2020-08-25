<?php


namespace App\SecondaryEacCode\Services;


use App\SecondaryEacCode\Contracts\SecondaryEanCodeRemovable;
use App\SecondaryEanCode;

class SecondaryEanCodeRemover implements SecondaryEanCodeRemovable
{
    /**
     * @param SecondaryEanCode $secondaryEanCode
     * @return bool
     * @throws \Exception
     */
    public function remove(SecondaryEanCode $secondaryEanCode)
    {
        try {
            $secondaryEanCode->delete();
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
