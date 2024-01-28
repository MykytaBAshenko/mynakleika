<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoicePayed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Invoice
     */
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->invoice->legalEntity->customer->user;

        return $this->markdown('vendor.mail.invoice-payed')
            ->to($user)
            ->subject('Статус оплаты')
            ->with([
                'user' => $user,
                'invoice' => $this->invoice
            ]);
    }
}
