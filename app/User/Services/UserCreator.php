<?php


namespace App\User\Services;


use App\Notifications\Wellcome;
use App\User;
use App\User\Contracts\UserCreatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreator implements UserCreatable
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
            $user = new User();
            $user->name = $userData['name'];
            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $user->password = Hash::make($password);
            $user->phone_1 = isset($userData['phone1']) ? $userData['phone1'] : null;
            $user->phone_2 = isset($userData['phone2']) ? $userData['phone2'] : null;
            $user->status = $userData['status'];
            $user->type = $userData['type'];
            $user->profile_id = $userData['profileId'];
            $user->save();
            $user->notify(new Wellcome($user, $password));
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
