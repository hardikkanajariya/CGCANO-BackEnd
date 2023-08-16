<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venues extends Model
{
    use HasFactory;
    protected $table = 'venues';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'state',
        'country',
        'longitude',
        'latitude',
        'postal_code',
        'amenities',
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Events', 'venue_id');
    }


}
