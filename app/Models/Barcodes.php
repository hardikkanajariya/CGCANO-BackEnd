<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcodes extends Model
{
    use HasFactory;

    protected $table = 'barcodes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'invoice_id',
        'barcode_img',
        'barcode_id',
        'data',
        'is_used',
        'is_expired'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
