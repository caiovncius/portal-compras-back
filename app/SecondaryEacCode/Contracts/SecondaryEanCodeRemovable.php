<?php


namespace App\SecondaryEacCode\Contracts;


use App\SecondaryEanCode;

interface SecondaryEanCodeRemovable
{
    /**
     * @param SecondaryEanCode $secondaryEanCode
     * @return bool
     * @throws \Exception
     */
    public function remove(SecondaryEanCode $secondaryEanCode);
}
