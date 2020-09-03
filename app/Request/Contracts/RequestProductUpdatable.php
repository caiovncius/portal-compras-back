<?php

namespace App\Request\Contracts;

use App\Request;

interface RequestProductUpdatable
{
    /**
     * @param Request $data
     * @param string $product
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public function update(Request $data, $product = '', array $newData);
}
