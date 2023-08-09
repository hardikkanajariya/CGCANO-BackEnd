<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'ticket_id',
        'quantity',
        'total_amount',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        // get event of this ticket
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'order_id');
    }


}
