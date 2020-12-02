<?php

namespace App\Imports;

use App\Offer;
use App\Product;
use App\ProductDetail;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
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
    private $model;

    /**
     * @var int
     */
    private $rows = 0;

    /**
     * OfferProductImport constructor.
     * @param Model $model
     * @param array $colsMap
     */
    public function __construct(Model $model, array $colsMap)
    {
        $this->model = $model;
        $this->colsMap = $colsMap;
        $this->cols = range('A', 'Z');
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return (int)$this->colsMap['startLine'];
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $validation = [
            $this->getColIndex($this->colsMap['eanCode']) => function($attribute, $value, $onFailure) {

                if (is_null($value) || empty($value)) {
                    $onFailure('Código EAN é obrigatório');
                }


                if (is_null($this->getProduct($value))) {
                    $onFailure('Produto não encontrado. Código EAN: ' . $value);
                }
            },
            $this->getColIndex($this->colsMap['startLine']) => 'required|numeric',
        ];

        if (!is_null($this->getIndexByColMap('familyMinQtd'))) {
            $validation[$this->getColIndex($this->colsMap['familyMinQtd'])] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('minQtd'))) {
            $validation[$this->getColIndex($this->colsMap['minQtd'])] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('qtdTo'))) {
            $validation[$this->getIndexByColMap('qtdTo')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('qtdFrom'))) {
            $validation[$this->getIndexByColMap('qtdFrom')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('fabPrice'))) {
            $validation[$this->getIndexByColMap('fabPrice')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('discountAv'))) {
            $validation[$this->getIndexByColMap('discountAv')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('priceAv'))) {
            $validation[$this->getIndexByColMap('priceAv')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('discountAp'))) {
            $validation[$this->getIndexByColMap('discountAp')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('priceAp'))) {
            $validation[$this->getIndexByColMap('priceAp')] = 'nullable';
        }

        if (!is_null($this->getIndexByColMap('required'))) {
            $validation[$this->getIndexByColMap('required')] = 'nullable|in:SIM,NÃO';
        }

        return $validation;
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
        $factoryPrice = !is_null($this->getIndexByColMap('fabPrice')) ? $row[$this->getIndexByColMap('fabPrice')] : 0;
        $discountOnCash = !is_null($this->getIndexByColMap('discountAv')) ? $row[$this->getIndexByColMap('discountAv')] : 0;
        $discountOnDeferred = !is_null($this->getIndexByColMap('discountAp')) ? $row[$this->getIndexByColMap('discountAp')] : 0;
        $priceOnCash = !is_null($this->getIndexByColMap('priceAv')) ? self::cleanNumber($row[$this->getIndexByColMap('priceAv')]) : ProductDetail::sumDiscount($factoryPrice, $discountOnCash);
        $priceDeferred = !is_null($this->getIndexByColMap('priceAp')) ? self::cleanNumber($row[$this->getIndexByColMap('priceAp')]) : ProductDetail::sumDiscount($factoryPrice, $discountOnDeferred);
        $minimumPerFamily = !is_null($this->getIndexByColMap('familyMinQtd')) ? $this->getIndexByColMap('familyMinQtd') : null;
        $minimum = !is_null($this->getIndexByColMap('minQtd')) ? $this->getIndexByColMap('minQtd') : null;


        if (is_null($product)) {
            $this->failures[$this->getColIndex($this->colsMap['eanCode'])] = new Failure(
                $this->rows,
                $this->getColIndex($this->colsMap['eanCode']),
                ['Produto não encontrado pelo código EAN']
            );
            return;
        }

        return $this->model->products()->create([
            'product_id' => !is_null($product) ? $product->id : null,
            'state_id' => $this->colsMap['stateId'],
            'minimum_per_family' => $minimumPerFamily,
            'minimum' => $minimum,
            'factory_price' => $factoryPrice,
            'discount_on_cash' => $discountOnCash,
            'price_on_cash' => $priceOnCash,
            'discount_deferred' => $discountOnDeferred,
            'price_deferred' => $priceDeferred,
            'quantity_minimum' => !is_null($this->getIndexByColMap('qtdTo')) ? $row[$this->getIndexByColMap('qtdTo')] : 0,
            'quantity_maximum' => !is_null($this->getIndexByColMap('qtdFrom')) ? $row[$this->getIndexByColMap('qtdFrom')] : 0,
            'obrigatory' => !is_null($this->getIndexByColMap('required')) ? (strtoupper($row[$this->getIndexByColMap('required')]) === 'SIM' ? true : false) : false,
        ]);

    }

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    public static function cleanNumber($string)
    {
        return preg_replace("/[^a-zA-Z]/", "", $string);
    }

    /**
     * @param $col
     * @return false|int|string|null
     */
    protected function getIndexByColMap($col)
    {
        if (!isset($this->colsMap[$col])) return null;
        return $this->getColIndex($this->colsMap[$col]);
    }

    /**
     * @param string $col
     * @return false|int|string
     */
    protected function getColIndex(string $col)
    {
        return array_search(strtoupper($col), $this->cols);
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getProductId(array $row)
    {
        $eanCode = $row[$this->getColIndex($this->colsMap['eanCode'])];
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
