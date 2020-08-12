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
                'pt' => 'Condicão',
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
        ];

        foreach($models as $model) {
            Functionality::create([
                'name' => $model['pt'],
                'key' => $model['en'],
            ]);
        }
    }
}
