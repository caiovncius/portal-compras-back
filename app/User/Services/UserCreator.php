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
    public function store(array $data)
    {
        try {

            $password = Str::random(8);

            $user = new User();
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = isset($data['password']) ? $data['password'] : Hash::make($password);
            $user->phone_1 = isset($data['phone1']) ? $data['phone1'] : null;
            $user->phone_2 = isset($data['phone2']) ? $data['phone2'] : null;
            $user->status = $data['status'];
            $user->type = $data['type'];
            $user->profile_id = $data['profileId'];
            $user->save();

            if (isset($data['pharmacies'])) {
                foreach ($data['pharmacies'] as $data) {
                    $user->pharmacies()->attach($data['id']);
                }
            }

            if (!isset($data['password'])) {
                $user->notify(new Wellcome($user, $password));
            }

            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
