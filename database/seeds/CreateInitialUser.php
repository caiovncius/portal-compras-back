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
        if (is_null(\App\User::where('email')->first())) {

        }
    }
}
