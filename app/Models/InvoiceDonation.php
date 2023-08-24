<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDonation extends Model
{
    use HasFactory;
    protected $table = 'invoice_donations';
    protected $primaryKey = 'id';
}
