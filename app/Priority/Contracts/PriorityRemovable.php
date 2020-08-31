<?php


namespace App\Priority\Contracts;


use App\Priority;

interface PriorityRemovable
{
    /**
     * @param Priority $priority
     * @return bool
     * @throws \Exception
     */
    public function delete(Priority $priority);
}
