<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSData extends Model
{
    use HasFactory;
    protected $table = 'pos_data';
    protected $primaryKey = 'id';
}
