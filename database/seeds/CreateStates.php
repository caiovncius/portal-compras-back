<?php

use Illuminate\Database\Seeder;

class CreateStates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = config('states');

        foreach ($states as $state) {
            if (is_null(\App\State::where('code', $state['code'])->first())) {
                \App\State::create($state);
            }
        }
    }
}
