<?php

namespace App\Exports;

use App\Pharmacy;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class PharmacyExport implements FromCollection, WithProperties, Responsable, WithMapping, WithHeadings
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
            'Razão Social',
            'Nome',
            'CNPJ',
            'Inscrição Estadual',
            'Email',
            'Telefone',
            'Supervisor',
            'Prioridade',
            'Endereço',
            'Complemento',
            'Número',
            'Bairro',
            'CEP',
            'Cidade',
            'Estado',
            'Status',
            'Data cadastro'
        ];
    }

    /**
     * @param mixed $pharmacy
     * @return array
     */
    public function map($pharmacy): array
    {
        return [
            $pharmacy->id,
            $pharmacy->code,
            $pharmacy->company_name,
            $pharmacy->name,
            $pharmacy->cnpj,
            $pharmacy->state_registration,
            $pharmacy->email,
            $pharmacy->phone,
            $pharmacy->supervisor_id !== null ? $pharmacy->supervisor->name : '',
            !is_null($pharmacy->priority) ? $pharmacy->priority->description : '',
            $pharmacy->address,
            $pharmacy->address_2,
            $pharmacy->address_number,
            $pharmacy->district,
            $pharmacy->zip_code,
            $pharmacy->city->name,
            $pharmacy->city->state->name,
            $pharmacy->status === Pharmacy::PHARMACY_STATUS_ACTIVE ? 'Ativo' : 'Inativo',
            Carbon::parse($pharmacy->created_at)->format('d/m/Y')
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pharmacy::all();
    }
}
