<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplates extends Model
{
    use HasFactory;

    protected $table = "email_templates";
    protected $primaryKey = "id";
    protected $fillable = [
        'event_id',
        'subject',
        'body',
        'flyer',
    ];

    // Get the Event Details
    public function event()
    {
        return $this->hasOne(EventList::class, 'id', 'event_id');
    }
}
