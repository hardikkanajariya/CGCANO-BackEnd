<?php

namespace App\Mail;

use App\Models\InvoiceComboTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComboInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public array $invoiceData = [];
    public function __construct($id)
    {
        $invoice = InvoiceComboTicket::find($id);
        $this->invoiceData = [
            "order_id" => $invoice->id,
            "Name" => $invoice->name,
            "quantity" => $invoice->quantity,
            "total_amount" => $invoice->total_amount,
            "fullname" => $invoice->full_name,
            "email" => $invoice->email,
            "phone" => $invoice->phone,
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Combo Invoice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.combo_invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
