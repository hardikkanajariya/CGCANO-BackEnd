<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;
    protected $table = 'tickets';
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
        return $this->belongsTo(Events::class, 'event_id');
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
        return $this->hasOne(Invoice::class, 'ticket_id');
    }

    // Count the number of tickets sold
    public function ticketsSold()
    {
        return $this->tickets()->where('is_sold_out', true)->count();
    }
}
