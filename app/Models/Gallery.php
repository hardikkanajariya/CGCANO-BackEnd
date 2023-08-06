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
    ];

    public function getPathAttribute($value)
    {
        return asset('images/gallery/' . $value);
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = time() . '_' . $value->getClientOriginalName();
        $value->move(public_path('images/gallery'), $this->attributes['path']);
    }
}
