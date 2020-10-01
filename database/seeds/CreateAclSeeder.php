<?php

use App\Functionality;
use Illuminate\Database\Seeder;

class CreateAclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            [
                'pt' => 'Acompanhamento',
                'en' => 'Accompaniment',
            ],
            [
                'pt' => 'Condições Especiais',
                'en' => 'Condition',
            ],
            [
                'pt' => 'Distribuidor',
                'en' => 'Distributor',
            ],
            [
                'pt' => 'Laboratório',
                'en' => 'Laboratory',
            ],
            [
                'pt' => 'Oferta',
                'en' => 'Offer',
            ],
            [
                'pt' => 'Farmácia',
                'en' => 'Pharmacy',
            ],
            [
                'pt' => 'Produto',
                'en' => 'Product',
            ],
            [
                'pt' => 'Programa',
                'en' => 'Program',
            ],
            [
                'pt' => 'Publicidade',
                'en' => 'Publicity',
            ],
            [
                'pt' => 'Retorno',
                'en' => 'Return',
            ],
            [
                'pt' => 'Usuário',
                'en' => 'User',
            ],
            [
                'pt' => 'Perfil',
                'en' => 'Profile',
            ],
            [
                'pt' => 'Compra Coletiva',
                'en' => 'Purchase',
            ],
            [
                'pt' => 'Pedido',
                'en' => 'Request',
            ],
            [
                'pt' => 'Prioridade',
                'en' => 'Priority',
            ]
        ];

        foreach($models as $model) {
            if (! Functionality::where('name', $model['pt'])->first()) {
                Functionality::create([
                    'name' => $model['pt'],
                    'key' => $model['en'],
                ]);
            }
        }
    }
}
