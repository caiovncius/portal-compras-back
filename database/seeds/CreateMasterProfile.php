<?php

use Illuminate\Database\Seeder;

class CreateMasterProfile extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (is_null(\App\Profile::where('type', \App\Profile::PROFILE_TYPE_MASTER)->first())) {
            \App\Profile::create([
                'name' => 'Master',
                'type' => \App\Profile::PROFILE_TYPE_MASTER
            ]);
        }
    }
}
