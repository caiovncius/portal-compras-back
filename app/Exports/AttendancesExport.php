<?php

namespace App\Exports;

use App\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendancesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('requests')
            ->select([
                'requests.id',
                'requests.status',
                'if(requests.payment_method = \'CASH\', \'à vista\', \'à prazo\') as payment_method',
                'pharmacies.name',
                'pharmacies.company_name',
                'pharmacies.cnpj',
                'products.code_ean',
                'products.code',
                'products.description',
                'request_products.requested_quantity',
                'request_products.unit_value',
                'request_products.discount_percentage',
                'request_products.total_discount',
                'request_products.total as product_total',
                'returns.description as return_description',
                'requests.subtotal',
                'requests.total_discount',
                'requests.total'
            ])
            ->join('request_products', 'request_products.request_id', '=', 'requests.id')
            ->join('pharmacies', 'pharmacies.id', '=', 'requests.pharmacy_id')
            ->leftJoin('returns', 'returns.id', '=', 'request_products.return_id')
            ->join('products', 'products.id', '=', 'request_products.product_id')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID pedido',
            'Status pedido',
            'Método de pagamento',
            'Nome farmácia',
            'Razão social farmácia',
            'CNPJ farmácia',
            'Cód. EAN produto',
            'Cód. produto',
            'Descrição produto',
            'Quantidade solicitada',
            'Valor unid.',
            'Desconto %',
            'Valor desconto',
            'Total produto',
            'Retorno',
            'Subtotal Pedido',
            'Total desconto pedido',
            'Total',
        ];
    }
}
