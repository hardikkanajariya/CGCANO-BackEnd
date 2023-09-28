<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;
    protected $table = 'event_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

    public function events()
    {
        return $this->hasMany(EventList::class, 'category_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'category_id', 'id');
    }
}
