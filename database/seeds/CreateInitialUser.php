<?php

use Illuminate\Database\Seeder;

class CreateInitialUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@associados.com';
        if (is_null(\App\User::where('email', $email)->first())) {

            $masterProfile = \App\Profile::where('type', \App\Profile::PROFILE_TYPE_MASTER)->first();

            if (is_null($masterProfile)) return;

            \App\User::create([
                'type' => \App\User::USER_TYPE_MASTER,
                'name' => 'Usuário master',
                'username' => 'master',
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'profile_id' => $masterProfile->id
            ]);
        }
    }
}
