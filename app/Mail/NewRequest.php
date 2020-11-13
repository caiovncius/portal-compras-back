<?php

namespace App\Mail;

use App\Offer;
use App\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NewRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Offer
     */
    public $offer;

    /**
     * @var Request
     */
    public $request;

    /**
     * NewRequest constructor.
     * @param Offer $offer
     */
    public function __construct(Offer $offer, Request $request)
    {
        $this->offer = $offer;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.new-request')
            ->subject('Pedido #' . $this->request->id . ' - Portal Associados')
            ->attach(storage_path('app/pedido_' . $this->request->id . '.xlsx'));
    }
}
