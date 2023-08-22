<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceComboTicket extends Model
{
    use HasFactory;
    protected $table = 'invoice_combo_tickets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'order_id',
        'combo_id',
        'quantity',
        'total_amount',
        'fullname',
        'email',
        'phone',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(ComboTicket::class, 'combo_id');
    }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'order_id');
    }
}
