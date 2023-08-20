<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberShipPackage extends Model
{
    use HasFactory;

    protected $table = 'membership_packages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'price',
        'description',
        'status',
    ];
}
