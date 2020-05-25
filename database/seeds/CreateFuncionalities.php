<?php

use Illuminate\Database\Seeder;

class CreateFuncionalities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $functionalities = config('functionalities');

        foreach ($functionalities as $functionality) {

            if (is_null(\App\Functionality::where('key', $functionality['key'])->first())) {
                \App\Functionality::create($functionality);
            }
        }
    }
}
