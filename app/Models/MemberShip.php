<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberShip extends Model
{
    use HasFactory;

    protected $table = 'memberships';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'price',
        'description',
        'status',
    ];
}
