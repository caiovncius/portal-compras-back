<?php

namespace App\Exports;

use App\Program;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;

class ProgramExport implements FromCollection, WithProperties, Responsable, WithMapping, WithHeadings
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
            'title'          => 'Programas',
            'description'    => 'Lista de programas - Portal Associados',
            'subject'        => 'Programas',
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
     * @param mixed $program
     * @return array
     */
    public function map($program): array
    {
        return [
            $program->id,
            $program->code,
            $program->name,
            $program->status === Program::PROGRAM_STATUS_ACTIVE ? 'Aivo' : 'Intivo',
            Carbon::parse($program->created_at)->format('d/m/Y')
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Program::all();
    }
}
