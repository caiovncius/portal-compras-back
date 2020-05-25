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
            $usersQuery = User::query();

            if (isset($querySearchParams['name']) && !empty($querySearchParams['name'])) {
                $usersQuery->where('name', 'like', '%' . $querySearchParams['name'] . '%');
            }

            if (isset($querySearchParams['email']) && !empty($querySearchParams['email'])) {
                $usersQuery->where('email', 'like', '%' . $querySearchParams['email'] . '%');
            }

            if (isset($querySearchParams['created_at']) && !empty($querySearchParams['created_at'])) {
                $usersQuery->where('created_at', '>=', $querySearchParams['created_at']);
            }

            if (isset($querySearchParams['status']) && !empty($querySearchParams['status'])) {
                $usersQuery->where('status', $querySearchParams['status']);
            }

            if (isset($querySearchParams['type']) && !empty($querySearchParams['type'])) {
                $usersQuery->where('type', $querySearchParams['type']);
            }

            $usersQuery->where('type', '!=', User::USER_TYPE_MASTER);

            return $usersQuery;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
