<?php


namespace App\Traits\Models;


trait UserScopes
{
    /**
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
