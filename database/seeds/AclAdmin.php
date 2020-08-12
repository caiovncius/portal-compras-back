<?php

use App\Functionality;
use App\Profile;
use Illuminate\Database\Seeder;

class AclAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = Profile::where('type', 'MASTER')->first();
        $functionalities = Functionality::all();
        foreach($functionalities as $func) {
            $func->profiles()->attach($profile->id, ['access_type' => 'FREE_ACCESS']);
        }
    }
}
