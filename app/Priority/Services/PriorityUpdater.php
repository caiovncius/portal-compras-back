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

            if (isset($newData['nationalPartner'])) {
                array_merge($partners, $newData['nationalPartner']);
            }

            if (isset($newData['regionalPartners'])) {
                array_merge($partners, $newData['nationalPartner']);
            }

            if (!empty($partners)) {
                $priority->partners()->sync($partners);
            }

            return true;

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
