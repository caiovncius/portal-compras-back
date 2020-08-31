<?php


namespace App\Priority\Services;


use App\Priority;
use App\Priority\Contracts\PriorityUpdatable;

class PriorityUpdater implements PriorityUpdatable
{
    public function update(Priority $priority, array $newData)
    {
        try {
            $priority->fill($newData);
            $priority->save();

            if (isset($data['partners'])) {
                $priority->partners()->sync($newData['partners']);
            }

            return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
