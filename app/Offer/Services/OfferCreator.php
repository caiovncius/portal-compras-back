<?php


namespace App\Offer\Services;

use App\Offer;
use App\Offer\Contracts\OfferCreatable;

class OfferCreator implements OfferCreatable
{
    /**
     * @param array $data
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $data)
    {
        try {
            $model = Offer::create($data);
            
            if (isset($data['partners'])) {
                foreach ($data['partners'] as $data) {
                    $model->partners()->attach($data['id'], ['type' => $data['type']]);
                }
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
