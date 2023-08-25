<?php

namespace App\Mail;

use App\Models\InvoiceCombo;
use App\Models\InvoicePackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoicePackageMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public array $invoiceData = [];
    public function __construct()
    {
        $invoice = InvoicePackage::find($id);
        $this->invoiceData = [
            "order_id" => $invoice->id,
            "Name" => $invoice->name,
            "total_amount" => $invoice->total_amount,
            "fullname" => $invoice->full_name,
            "email" => $invoice->email,
            "phone" => $invoice->phone,
            "package_name" => $invoice->package->name,
            "pdf" => $invoice->pdf,
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Package Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice_package',
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
