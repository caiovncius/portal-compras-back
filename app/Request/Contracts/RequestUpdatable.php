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

    /**
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function cancel(Request $request);

    /**
     * @param Request $request
     * @param string $status
     * @param int $returnId
     * @return bool
     * @throws \Exception
     */
    public function updateAllProductStatus(Request $request, string $status, int $returnId);

    /**
     * @param Request $request
     * @param array $items
     * @return bool
     * @throws \Exception
     */
    public function massUpdateProductStatus(Request $request, array $items);
}
