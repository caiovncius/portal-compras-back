<?php


namespace App\Priority\Contracts;


interface PriorityRetrievable
{
    public function getPriorities(array $params);

    public function getNationalPartners();

    public function getRegionalPartners();
}
