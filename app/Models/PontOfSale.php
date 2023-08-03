<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontOfSale extends Model
{
    use HasFactory;
    protected $table = 'point_of_sales';
    protected $primaryKey = 'id';
}
