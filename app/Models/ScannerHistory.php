<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannerHistory extends Model
{
    use HasFactory;
    protected $table = 'scanner_history';
    protected $primaryKey = 'id';
}
