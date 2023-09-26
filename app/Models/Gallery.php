<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'path',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id', 'id');
    }
}
