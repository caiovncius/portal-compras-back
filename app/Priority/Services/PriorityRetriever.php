<?php


namespace App\Priority\Services;


use App\Priority;
use App\Priority\Contracts\PriorityRetrievable;

class PriorityRetriever implements PriorityRetrievable
{
    public function getPriorities(array $params)
    {
        try {
            $query = Priority::query();

            if (isset($params['id'])) {
                $query->where('id', $params['id']);
            }

            if (isset($params['description'])) {
                $query->where('description', $params['description']);
            }

            if (isset($params['status'])) {
                $query->where('status', $params['status']);
            }

            return $query;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getNationalPartners()
    {
        try {
            return (new \App\Distributor())->nationalPartners();
        } catch (\Exception $e) {
            throw  $e;
        }
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getRegionalPartners()
    {
        try {
            return \App\Distributor::regionalPartners();
        } catch (\Exception $e) {
            throw  $e;
        }
    }
}
