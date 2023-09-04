<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventList extends Model
{
    use HasFactory;
    protected $table = 'event_list';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'venue_id',
        'speaker_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\EventCategory', 'category_id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Models\Venues', 'venue_id');
    }

    public function speaker()
    {
        return $this->belongsTo('App\Models\Speakers', 'speaker_id');
    }

    public function sponsors()
    {
        return $this->hasMany('App\Models\Sponsors', 'event_id');
    }

    public function tickets()
    {
        return $this->hasOne('App\Models\TicketEvent', 'event_id')->where('status', true);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\InvoiceTicket', 'event_id');
    }

    // Count the number of tickets sold
    public function ticketsSold()
    {
        // get All TicketEvent for this event
        $tickets = $this->tickets()->get();
        $ticketsSold = 0;

        // get the order list for each ticket
        foreach ($tickets as $ticket) {
            $orders = InvoiceTicket::where('ticket_id', $ticket->id)->get();
            foreach ($orders as $order) {
                $ticketsSold += $order->quantity;
            }
        }
        return $ticketsSold;
    }
}
