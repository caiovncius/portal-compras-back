<?php

use Illuminate\Database\Seeder;

class CreatePublicity extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicity = \App\Publicity::query()->first();

        if (is_null($publicity)) {
            \App\Publicity::create();
        }
    }
}
