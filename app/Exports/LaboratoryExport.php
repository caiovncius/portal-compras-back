<?php

namespace App\Exports;

use App\Laboratory;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class LaboratoryExport implements FromCollection, WithProperties, Responsable, WithMapping, WithHeadings
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
            'title'          => 'Laboratorios',
            'description'    => 'Lista de laboratorios - Portal Associados',
            'subject'        => 'Laboratorios',
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
            'Nome',
            'Status',
            'Data cadastro'
        ];
    }

    /**
     * @param mixed $distributor
     * @return array
     */
    public function map($laboratory): array
    {
        return [
            $laboratory->id,
            $laboratory->code,
            $laboratory->name,
            $laboratory->status === Laboratory::LABORATORY_STATUS_ACTIVE ? 'Ativo' : 'Inativo',
            Carbon::parse($laboratory->created_at)->format('d/m/Y')
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Laboratory::all();
    }
}
