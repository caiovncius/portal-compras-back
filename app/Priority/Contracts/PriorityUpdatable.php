<?php


namespace App\Priority\Contracts;


use App\Priority;

interface PriorityUpdatable
{
    public function update(Priority $priority, array $newData);
}
