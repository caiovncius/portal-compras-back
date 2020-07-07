<?php


namespace App\Program\Services;


use App\Program;
use App\Program\Contracts\ProgramRetrievable;

class ProgramRetriever implements ProgramRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getPrograms(array $params = [])
    {
        try {
            $query = Program::query();

            if (isset($params['code']) && !empty($params['code'])) {
                $query->where('code', $params['code']);
            }

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (isset($params['status']) && !empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
