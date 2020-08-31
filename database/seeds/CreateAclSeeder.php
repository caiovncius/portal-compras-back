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
                'pt' => 'Condição',
                'en' => 'Condition',
            ],
            [
                'pt' => 'Conexão',
                'en' => 'Connection',
            ],
            [
                'pt' => 'Contato',
                'en' => 'Contact',
            ],
            [
                'pt' => 'Distribuidor',
                'en' => 'Distributor',
            ],
            [
                'pt' => 'Funcionalidade',
                'en' => 'Functionality',
            ],
            [
                'pt' => 'Laboratorio',
                'en' => 'Laboratory',
            ],
            [
                'pt' => 'Oferta',
                'en' => 'Offer',
            ],
            [
                'pt' => 'Oferta Produto',
                'en' => 'Offer_Product',
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
                'pt' => 'Compra coletiva',
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
