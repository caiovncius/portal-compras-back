<?php

namespace App\Imports;

use App\Offer;
use App\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class OfferProductImport implements ToModel, WithValidation, WithBatchInserts, SkipsOnFailure, SkipsOnError, WithStartRow
{

    use Importable, SkipsFailures, SkipsErrors;


    /**
     * @var array
     */
    protected $colsMap = [];

    /**
     * @var array
     */
    public $cols = [];

    /**
     * @var Offer
     */
    private $offer;

    private $rows = 0;

    /**
     * OfferProductImport constructor.
     * @param Offer $offer
     * @param array $colsMap
     */
    public function __construct(Offer $offer, array $colsMap)
    {
        $this->offer = $offer;
        $this->colsMap = $colsMap;
        $this->cols = range('A', 'Z');
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return (int)$this->colsMap['start_line'];
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return (int)$this->colsMap['start_line'] - 1;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            $this->getColIndex($this->colsMap['ean_code']) => function($attribute, $value, $onFailure) {

                if (is_null($value) || empty($value)) {
                    $onFailure('Código EAN é obrigatório');
                }

                if (is_null($this->getProduct($value))) {
                    $onFailure('Produto não encontrado. Código EAN: ' . $value);
                }
            },
            $this->getColIndex($this->colsMap['family_min_qtd']) => 'required',
            $this->getColIndex($this->colsMap['min_qtd']) => 'required',
        ];
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|void|null
     */
    public function model(array $row)
    {
        ++$this->rows;
        $clearRows = array_values($row);
        $product = $this->getProductId($clearRows);

        return $this->offer->products()->create([
            'product_id' => !is_null($product) ? $product->id : null,
            'state_id' => $this->colsMap['state_id'],
            'discount_deferred' => $this->getColIndex('discount_ap') ? $this->getColIndex('discount_ap') : 0,
            'discount_on_cash' => $this->getColIndex('discount_av') ? $this->getColIndex('discount_av') : 0,
            'minimum_per_family' => $this->getColIndex('family_min_qtd'),
            'minimum' => $this->getColIndex('qtd_minima'),
            'factory_price' => $this->getColIndex('fab_price') ? $this->getColIndex('fab_price') : 0,
            'price_deferred' => $this->getColIndex('price_ap') ? $this->getColIndex('price_ap') : 0,
            'price_on_cash' => $this->getColIndex('price_av') ? $this->getColIndex('price_av') : 0,
            'quantity_minimum' => $this->getColIndex('qtd_to') ? $this->getColIndex('qtd_to') : 0,
            'quantity_maximum' => $this->getColIndex('qtd_until') ? $this->getColIndex('qtd_until') : 0,
            'obrigatory' => $this->getColIndex('required') ? $this->getColIndex('required') : false,
            'updated_id' => auth()
        ]);

    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    /**
     * @param string $col
     * @return false|int|string
     */
    protected function getColIndex(string $col)
    {
        return array_search($col, $this->cols);
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getProductId(array $row)
    {
        $eanCode = $row[$this->getColIndex($this->colsMap['ean_code'])];
        return $this->getProduct($eanCode);
    }

    /**
     * @param string $eanCode
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    protected function getProduct(string $eanCode)
    {
        return Product::with(['secondaryEanCodes'])
            ->where('code_ean', $eanCode)
            ->orWhereHas('secondaryEanCodes', function($query) use($eanCode) {
                $query->where('name', $eanCode);
            })->first();
    }
}