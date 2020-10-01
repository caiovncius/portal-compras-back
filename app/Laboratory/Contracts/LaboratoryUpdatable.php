<?php


namespace App\Laboratory\Contracts;


use App\Laboratory;

interface LaboratoryUpdatable
{
    /**
     * @param Laboratory $laboratory
     * @param array $laboratoryData
     * @return bool
     * @throws \Exception
     */
    public function update(Laboratory $laboratory, array $laboratoryData);

    /**
     * @param Laboratory $laboratory
     * @param array $contactData
     * @return bool
     * @throws \Exception
     */
    public function addContact(Laboratory $laboratory, array $contactData);

    /**
     * @param Laboratory $laboratory
     * @return bool
     */
    public function enable(Laboratory $laboratory);
}
