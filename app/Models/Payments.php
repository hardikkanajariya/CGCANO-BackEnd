<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'payment_amount',
        'payment_date',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Invoice::class, 'order_id');
    }
}
