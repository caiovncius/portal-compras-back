<?php

namespace App\Jobs;

use App\Mail\NewRequest;
use App\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ManualOffers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $offer;

    /**
     * ManualOffers constructor.
     * @param Offer $offer
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to = [];
        $cc = [];
        $cco = [];

        Mail::to($to)
            ->cc($cc)
            ->bcc($cco)
            ->queue((new NewRequest($this->offer))->onQueue('emails'));
    }
}
