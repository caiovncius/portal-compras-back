<?php

namespace App\Services;

use App\Request;

class PortalDashboard {

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

		dd($dash);
	}

	public function getQtdRequestsByMonth($requests)
	{
		$data = [];
		for($i=1;$i<=12;$i++) {
			$data[$i] = $requests->where('month', $i)->count();
		}
		
		return $data;
	}

	public function getQtdPharmaciesByMonth($requests)
	{
		$data = [];
		for($i=1;$i<=12;$i++) {
			$data[$i] = $requests->where('month', $i)
								 ->unique('pharmacy_id')
								 ->count();
		}
		
		return $data;
	}

	public function getPromotions($requests)
	{
		
	}
}