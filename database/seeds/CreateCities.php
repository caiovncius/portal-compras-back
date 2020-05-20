<?php

use Illuminate\Database\Seeder;

class CreateCities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = config('cities');

        foreach ($cities as $city) {
            $state = \App\State::where('code', $city['state'])->first();
            if (is_null($state)) continue;

            $existCity = \App\City::where('name', $city['name'])
                ->where('state_id', $state->id)
                ->first();
            if (is_null($existCity)) {
                \App\City::create([
                    'name' => $city['name'],
                    'state_id' => $state->id
                ]);
            }
        }
    }
}
