<?php

use Illuminate\Database\Seeder;

class CreateTestProfile extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (is_null(\App\Profile::where('name', 'Teste Farmácia')->first())) {
            \App\Profile::create([
                'name' => 'Teste',
                'type' => \App\Profile::PROFILE_TYPE_PHARMACY
            ]);
        }
    }
}
