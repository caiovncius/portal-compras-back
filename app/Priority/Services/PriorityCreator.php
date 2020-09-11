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

            if (isset($data['nationalPartners'])) {
                array_merge($partners, $data['nationalPartners']);
            }

            if (isset($data['regionalPartners'])) {
                array_merge($partners, $data['regionalPartners']);
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
