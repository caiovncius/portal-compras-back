<?php


namespace App\Priority\Services;


use App\Priority;
use App\Priority\Contracts\PriorityRemovable;

class PriorityRemover implements PriorityRemovable
{
    /**
     * @param Priority $priority
     * @return bool
     * @throws \Exception
     */
    public function delete(Priority $priority)
    {
        try {
            $priority->status = Priority::PRIORITY_STATUS_INACTIVE;
            $priority->save();
            return true;
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
