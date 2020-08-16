<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CreateStates::class);
         $this->call(CreateCities::class);
         $this->call(CreateMasterProfile::class);
         $this->call(CreateFuncionalities::class);
         $this->call(CreateInitialUser::class);
         $this->call(CreateTestProfile::class);
         $this->call(CreatePublicity::class);
         $this->call(CreateAclSeeder::class);
         $this->call(AclAdmin::class);
    }
}
