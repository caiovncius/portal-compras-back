<?php

namespace App\Jobs;

use App\Exports\RequestExport;
use App\Mail\NewRequest;
use App\Offer;
use App\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ManualOffers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Offer
     */
    public $offer;

    /**
     * @var Request
     */
    public $request;

    /**
     * ManualOffers constructor.
     * @param Offer $offer
     */
    public function __construct(Offer $offer, Request $request)
    {
        $this->offer = $offer;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $collectEmails = collect($this->offer->emails);

        $to = $collectEmails->where('send', 'to')->map(function ($email, $index) {
            return $email['email'];
        });

        $cc = $collectEmails->where('send', 'cc')->map(function ($email, $index) {
            return $email['email'];
        });

        $cco = $collectEmails->where('send', 'cco')->map(function ($email, $index) {
            return $email['email'];
        });

        $this->generateExcel();

        Mail::to($to->toArray())
            ->cc($cc->toArray())
            ->bcc($cco->toArray())
            ->send(new NewRequest($this->offer, $this->request))->onQueue('emails');
    }

    private function generateExcel()
    {
        return \Excel::store(new RequestExport($this->request), 'pedido_' . $this->request->id . '.xlsx');
    }
}
