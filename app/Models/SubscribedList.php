<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribedList extends Model
{
    use HasFactory;

    protected $table = 'subscribed_lists';

    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
