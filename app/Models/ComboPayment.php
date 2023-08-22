<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboPayment extends Model
{
    use HasFactory;
    protected $table = 'combo_payments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'billing_token',
        'payment_amount',
        'facilitator_access_token',
        'paypal_order_id',
        'payer_id',
        'payer_name',
        'payer_email',
        'payer_address',
        'gross_amount',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(InvoiceComboTicket::class, 'order_id');
    }
}
