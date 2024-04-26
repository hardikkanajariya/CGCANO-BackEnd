<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTicket extends Model
{
    use HasFactory;

    protected $table = 'invoice_ticket';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'ticket_id',
        'quantity',
        'total_amount',
        'is_paid',
        'full_name',
        'email',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        // get event of this ticket
        return $this->belongsTo(TicketEvent::class, 'ticket_id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentEvent::class, 'order_id');
    }

    public function event(){
        return $this->belongsTo(EventList::class, 'ticket_id', 'id');
    }

    public function volunteer(){
        return $this->belongsTo(Volunteers::class, 'sold_by', 'id');
    }
}
