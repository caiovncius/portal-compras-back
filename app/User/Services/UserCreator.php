<?php


namespace App\User\Services;


use App\Notifications\Wellcome;
use App\User;
use App\User\Contratcs\UserCreatorable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreator implements UserCreatorable
{
    /**
     * @param array $userData
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(array $userData)
    {
        try {
            $password = Str::random(8);
            $userData['password'] = Hash::make($password);
            $user = User::create($userData);
            $user->notify(new Wellcome($user, $password));
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
