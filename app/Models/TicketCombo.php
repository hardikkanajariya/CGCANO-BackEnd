<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCombo extends Model
{
    use HasFactory;

    protected $table = 'tickets_combo';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'quantity',
        'status',
        'event_id',
    ];

    protected $casts = [
        'event_id' => 'array',
    ];

    public function events()
    {
        return $this->belongsToMany(EventList::class);
    }
}
