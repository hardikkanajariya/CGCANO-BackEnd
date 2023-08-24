<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePackage extends Model
{
    use HasFactory;
    protected $table = 'invoice_packages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'package_id',
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

    public function package()
    {
        return $this->belongsTo(MemberShip::class, 'package_id');
    }

    public function payment()
    {
        return $this->hasOne(PackagePayment::class, 'order_id');
    }
}
