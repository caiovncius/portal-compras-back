<?php


namespace App\Profile\Services;


use App\Functionality;
use App\Profile;
use App\Profile\Contracts\ProfileCreatable;

class ProfileCreator implements ProfileCreatable
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
            $profile = Profile::create($data);

            foreach ($data['permissions'] as $function) {
                $permission = Functionality::where('key', $function['functionality'])->first();
                $profile->functionalities()->attach($permission->id, ['access_type' => $function['permission']]);
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
