<?php

namespace App\Mail;

use App\Models\EventList;
use App\Models\InvoiceTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InvoiceTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $invoice_path;
    public $fullname;
    public $event;
    public $venue;
    public $address;
    public function __construct($path, $fullname)
    {
        $this->invoice_path = $path;
        $this->fullname = $fullname;
        $invoice = InvoiceTicket::where('pdf', Str::after($path, 'invoices/'))->first();
        $this->event = $invoice->ticket->event;
        $this->venue = $this->event->venue;
        $this->address = $this->venue->address;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice_ticket',
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
