<?php


namespace App\Laboratory\Services;

use App\Laboratory;
use App\Laboratory\Contracts\LaboratoryCreatable;

class LaboratoryCreator implements LaboratoryCreatable
{
    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $data['updated_id'] = auth()->guard('api')->user()->id;
            $laboratory = Laboratory::create($data);

            if (isset($data['contacts']) && !empty($data['contacts'])) {
                foreach($data['contacts'] as $contact) {
                    $contact['updated_id'] = auth()->guard('api')->user()->id;
                    $laboratory->contacts()->create($contact);
                }
            }

            return $laboratory;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
