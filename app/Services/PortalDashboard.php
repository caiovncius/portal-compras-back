<?php

namespace App\Services;

use App\Request;
use Illuminate\Support\Carbon;
use stdClass;

class PortalDashboard
{
    /**
     * @return array
     * @throws \Exception
     */
    public function dashboard()
    {
        $user = auth()->guard('api')->user();
        $profile = $user->profile->type;
        if ($profile == 'PHARMACY') {
            return [];
        }

        $requests = Request::whereYear('created_at', '=', date('Y'));
        if ($profile == 'COMMERCIAL') {
            $pharmacies = $user->pharmacies()->active()->get()->toArray();
            $requests = $requests->whereIn('pharmacy', $pharmacies);
        }
        $requests = $requests->get();

        $dash['qtdRequests'] = $this->getQtdRequestsByMonth($requests);
        $dash['qtdPharmacies'] = $this->getQtdPharmaciesByMonth($requests);
        $dash['promotions'] = $this->getPromotions($requests);
        $dash['pharmacies'] = $this->getPharmacies($requests);

        return $dash;
    }

    /**
     * @param $requests
     * @return array
     * @throws \Exception
     */
    public function getQtdRequestsByMonth($requests)
    {
        $data = [];
        for ($i=1; $i<=12; $i++) {
            $data[] = [
                'label' => (new Carbon)->month($i)->monthName,
                'value' => $requests->where('month', $i)->count()
            ];
        }

        return $data;
    }

    /**
     * @param $requests
     * @return array
     * @throws \Exception
     */
    public function getQtdPharmaciesByMonth($requests)
    {
        $data = [];
        for ($i=1; $i<=12; $i++) {
            $data[] = [
                'label' => (new Carbon)->month($i)->monthName,
                'value' => $requests->where('month', $i)
                    ->unique('pharmacy_id')
                    ->count()
            ];
        }

        return $data;
    }

    /**
     * @param $requests
     * @return \Illuminate\Support\Collection
     */
    public function getPromotions($requests)
    {
        $arr = $requests->map(function ($request) {
            $products = [];
            foreach ($request->products as $product) {
                if ($product) {
                    $item['product'] = $product->description;
                    $products[] = $item;
                }
            }
            return $products;
        });
        $products = [];
        foreach ($arr->filter() as $key => $items) {
            foreach ($items as $item) {
                $products[] = $item;
            }
        }

        $values = collect($products)->groupBy('product')->map(function ($items) {
            return [
                'item' => $items->first()['product'],
                'qtd' => $items->count()
            ];
        });

        return $values->sortByDesc('qtd')->take(10);
    }

    /**
     * @param $requests
     * @return mixed
     */
    public function getPharmacies($requests)
    {
        $data = $requests->groupBy('pharmacy_id')->map(function ($item, $key) {
            return [
                'cnpj' => $item->first()->pharmacy->cnpj,
                'pharmacy' => $item->first()->pharmacy->name,
                'count' => $item->count(),
                'value' => $item->sum('value'),
            ];
        });

        return $data->sortByDesc('count')->take(10);
    }
}
