<?php

namespace App\Exports;

use App\Distributor;
use App\Program;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class DistributorExport implements FromCollection, WithProperties, Responsable, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * @return array
     */
    public function properties(): array
    {
        return [
            'creator'        => 'Portal Associados',
            'lastModifiedBy' => 'Portal Associados',
            'title'          => 'Distribuidoras',
            'description'    => 'Lista de distribuidoras - Portal Associados',
            'subject'        => 'Distribuidoras',
            'company'        => 'Portal Associados',
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'CNPJ',
            'Nome',
            'Estado',
            'Categoria',
            'Status',
            'Data cadastro'
        ];
    }

    /**
     * @param mixed $distributor
     * @return array
     */
    public function map($distributor): array
    {
        return [
            $distributor->id,
            $distributor->code,
            $distributor->cnpj,
            $distributor->name,
            $distributor->state->name,
            $distributor->category === Distributor::CATEGORY_NATIONAL ? 'Nacional' : 'Regional',
            $distributor->status === Distributor::DISTRIBUTOR_STATUS_ACTIVE ? 'Ativo' : 'Inativo',
            Carbon::parse($distributor->created_at)->format('d/m/Y')
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Distributor::all();
    }
}
