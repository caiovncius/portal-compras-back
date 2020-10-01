<?php

namespace App\Services;

use App\Mail\PurchaseMail;
use App\Purchase;
use Illuminate\Support\Facades\Mail;

class PurchaseCheck
{
    public function check()
    {
        $purchases = Purchase::where('status', 'OPEN')
                             ->get();
        foreach ($purchases as $purchase) {
            if ($purchase->validity_end < date('Y-m-d')) {
                $purchase->status = 'LATE';
                $purchase->save();
                continue;
            }
            $allIntentions = $purchase->requests()->get();
            $totalIntentions = $allIntentions->count();
            $amountIntentions = $allIntentions->sum('value');
            if (count($allIntentions) == 0) {
                continue;
            }
            
            if (($amountIntentions >= $purchase->minimum_billing_value) && 
                ($totalIntentions >= $purchase->minimum_billing_quantity)) { 
                if ($purchase->send_type == 'AUTOMATIC') {
                    $purchase->status = 'BILLED';
                    $purchase->save();
                    
                    $this->sendFtp($purchase);
                } else {
                    $purchase->status = 'READY_SEND';
                    $purchase->save();

                    $this->sendMail($purchase);
                }
            }
        }
    }

    public function sendFtp(Purchase $purchase) {
        try {
            foreach($purchase->requests()->get() as $request) {
                (new RequestPurchase())->send($request);
            }

            return true;
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function sendMail(Purchase $purchase) {
        try {
            foreach($purchase->contacts as $contact) {
                Mail::to($contact['email'])->send(new PurchaseMail($purchase));
            }

            return true;
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
