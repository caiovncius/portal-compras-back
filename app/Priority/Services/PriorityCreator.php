<?php


namespace App\Priority\Services;


use App\Priority\Contracts\PriorityCreatable;

class PriorityCreator implements PriorityCreatable
{
    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $priority = new \App\Priority();
            $priority->description = $data['description'];
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
}
