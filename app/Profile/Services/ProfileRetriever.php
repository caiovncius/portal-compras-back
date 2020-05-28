<?php


namespace App\Profile\Services;


use App\Profile;
use App\Profile\Contracts\ProfileRetrievable;

class ProfileRetriever implements ProfileRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function profiles(array $params)
    {
        try {
            $query = Profile::query();

            if (isset($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (isset($params['type'])) {
                $query->where('name', $params['type']);
            }

            if (isset($params['status'])) {
                $query->where('name', $params['status']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
