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

            $partners = [];

            if (isset($newData['nationalPartners']) && !empty($newData['nationalPartners'])) {
                $partners = array_merge($partners, $newData['nationalPartners']);
            }

            if (isset($newData['regionalPartners']) && !empty($newData['regionalPartners'])) {
                $partners = array_merge($partners, $newData['regionalPartners']);
            }

            if (!empty($partners)) {
                $priority->partners()->sync($partners);
            }

            return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Priority $priority
     * @return bool
     */
    public function enable(Priority $priority)
    {
        $priority->status = Priority::PRIORITY_STATUS_ACTIVE;
        $priority->save();
        return true;
    }
}
