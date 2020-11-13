<?php

namespace App\Exports;

use App\Helpers\Common;
use App\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestExport implements FromCollection, WithHeadings
{
    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $result = [];

        foreach ($this->request->products as $product) {
            $result[] = [
                'CODIGO' => $this->request->pharmacy->code,
                'CNPJ' => $this->request->pharmacy->cnpj,
                'CODIGOEAN' => $product->code_ean,
                'PRODUTO' => $product->description,
                'PRECO' => 'R$' . str_replace('.', ',', $product->pivot->unit_value),
                'QUANTIDADE' => $product->pivot->requested_quantity,
            ];
        }
        return collect($result);
    }

    public function headings(): array
    {
        return [
            'Código',
            'CNPJ',
            'Código EAN',
            'Produto',
            'Preço',
            'Quantidade'
        ];
    }
}
