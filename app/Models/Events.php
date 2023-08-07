<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'venue_id',
        'speaker_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\EventCategory', 'category_id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Models\Venues', 'venue_id');
    }

    public function speaker()
    {
        return $this->belongsTo('App\Models\Speakers', 'speaker_id');
    }

    public function sponsors()
    {
        return $this->hasMany('App\Models\Sponsors', 'event_id');
    }


}
