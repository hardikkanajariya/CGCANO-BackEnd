<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketEvent extends Model
{
    use HasFactory;

    protected $table = 'tickets_event';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'price',
        'quantity',
        'tickets_left',
        'is_sold_out',
        'is_active',
    ];

    public function event()
    {
        return $this->belongsTo(EventList::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barcode()
    {
        return $this->hasOne(Barcodes::class, 'ticket_id');
    }

    public function order()
    {
        return $this->hasOne(InvoiceTicket::class, 'ticket_id');
    }

    // Count the number of tickets sold
    public function ticketsSold()
    {
        return $this->tickets()->where('is_sold_out', true)->count();
    }
}
