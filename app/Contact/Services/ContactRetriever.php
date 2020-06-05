<?php


namespace App\Contact\Services;


use App\Contact;
use App\Contact\Contracts\ContactRetrievable;

class ContactRetriever implements ContactRetrievable
{
    /**
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getContacts(array $params = [])
    {
        try {
            $query = Contact::query();

            if (isset($params['distributor_id']) && !empty($params['distributor_id'])) {
                $query->where('distributor_id', $params['distributor_id']);
            }

            if (isset($params['function']) && !empty($params['function'])) {
                $query->where('function', $params['function']);
            }

            if (isset($params['name']) && !empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }

            if (isset($params['email']) && !empty($params['email'])) {
                $query->where('email', $params['email']);
            }

            if (isset($params['telephone']) && !empty($params['telephone'])) {
                $query->where('telephone', $params['telephone']);
            }

            if (isset($params['createdAt']) && !empty($params['createdAt'])) {
                $query->where('created_at', '>=', $params['created_at']);
            }

            return $query;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
