<?php


namespace App\User\Services;


use App\User;
use App\User\Contracts\UserRetrievable;

class UserRetriever implements UserRetrievable
{
    /**
     * @param array $querySearchParams
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Exception
     */
    public function getUsers(array $querySearchParams = [])
    {
        try {
            $usersQuery = User::with(['pharmacies']);

            if (isset($querySearchParams['name']) && !empty($querySearchParams['name'])) {
                $usersQuery->where('name', 'like', '%' . $querySearchParams['name'] . '%');
            }

            if (isset($querySearchParams['email']) && !empty($querySearchParams['email'])) {
                $usersQuery->where('email', 'like', '%' . $querySearchParams['email'] . '%');
            }

            if (isset($querySearchParams['createdAt']) && !empty($querySearchParams['createdAt'])) {
                $usersQuery->where('created_at', '>=', $querySearchParams['created_at']);
            }

            if (isset($querySearchParams['status']) && !empty($querySearchParams['status'])) {
                $usersQuery->where('status', $querySearchParams['status']);
            }

            if (isset($querySearchParams['type']) && !empty($querySearchParams['type'])) {
                $usersQuery->where('type', $querySearchParams['type']);
            }

            if (isset($querySearchParams['cnpj']) && !empty($querySearchParams['cnpj'])) {
                $usersQuery->whereHas('pharmacies', function ($q) use($querySearchParams) {
                    $q->where('cnpj', 'like', '%' . $querySearchParams['cnpj'] . '%');
                });
            }

            return $usersQuery;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
