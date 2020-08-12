<?php

use App\Functionality;
use App\Profile;
use Illuminate\Database\Seeder;

class AclModulePurchase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = Profile::where('type', 'MASTER')->first();
        $func = Functionality::create([
            'name' => 'Compra coletiva',
            'key' => 'Purchase',
        ]);
        $func->profiles()->attach($profile->id, ['access_type' => 'FREE_ACCESS']);

        $func = Functionality::create([
            'name' => 'Pedido',
            'key' => 'Request',
        ]);
        $func->profiles()->attach($profile->id, ['access_type' => 'FREE_ACCESS']);
    }
}
