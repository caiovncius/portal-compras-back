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
        $cities = json_decode(file_get_contents(config_path('/cities.json')));

        foreach ($cities as $city) {
            $state = \App\State::where('code', $city->state)->first();
            if (is_null($state)) continue;

            $existCity = \App\City::where('name', $city->name)
                ->where('state_id', $state->id)
                ->first();

            if (is_null($existCity)) {
                \App\City::create([
                    'ibge_code' => $city->ibge_code,
                    'name' => $city->name,
                    'state_id' => $state->id
                ]);
            } else {
                $existCity->ibge_code = $city->ibge_code;
                $existCity->name = strtoupper($city->name);
                $existCity->save();
            }
        }
    }
}
