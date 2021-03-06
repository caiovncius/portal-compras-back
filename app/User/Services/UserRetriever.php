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

            if (isset($querySearchParams['startDate']) && !empty($querySearchParams['startDate'])) {
                $usersQuery->whereDate('created_at', '>=', $querySearchParams['startDate']);
            }

            if (isset($querySearchParams['endDate']) && !empty($querySearchParams['endDate'])) {
                $usersQuery->whereDate('created_at', '<=', $querySearchParams['endDate']);
            }

            if (isset($querySearchParams['status']) && !empty($querySearchParams['status'])) {
                $usersQuery->where('status', $querySearchParams['status']);
            }

            if (isset($querySearchParams['type']) && !empty($querySearchParams['type'])) {
                $usersQuery->where('type', $querySearchParams['type']);
            }

            if (isset($querySearchParams['cnpj']) && !empty($querySearchParams['cnpj'])) {
                $usersQuery->whereHas('pharmacies', function ($q) use($querySearchParams) {
                    $cleanCNPJ = preg_replace('/[^0-9]/', '', $querySearchParams['cnpj']);
                    $q->where('pharmacies.cnpj', 'like', '%' . $cleanCNPJ . '%');
                });
            }

            return $usersQuery;

        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
