<?php

namespace App\Request\Contracts;

use App\Request;

interface RequestUpdatable
{
    /**
     * @param Request $data
     * @param array $newData
     * @return bool
     * @throws \Exception
     */
    public  function update(Request $data, array $newData);

    public function cancel(Request $request);
}
