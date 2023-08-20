<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboTicket extends Model
{
    use HasFactory;

    protected $table = 'combo_tickets';

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
        return $this->belongsToMany(Events::class);
    }
}
