<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCombo extends Model
{
    use HasFactory;
    protected $table = 'invoice_combo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'order_id',
        'combo_id',
        'quantity',
        'total_amount',
        'full_name',
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
        return $this->belongsTo(TicketCombo::class, 'combo_id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentCombo::class, 'order_id');
    }
}
