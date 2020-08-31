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

            if (isset($data['partners'])) {
                $priority->partners()->sync($data['partners']);
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
