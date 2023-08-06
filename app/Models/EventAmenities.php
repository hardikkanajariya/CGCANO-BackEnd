<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAmenities extends Model
{
    use HasFactory;

    protected $table = 'event_amenities';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'image',
    ];


}
