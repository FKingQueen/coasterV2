<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coastalID',
        'coastalProtection',
        'conditionRating',
        'crDesc',
        'heightRange',
        'length',
        'locationType',
        'prDesc',
        'primaryMaterial',
        'priorityRating',
        'province',
        'yearCompleted',
        'image',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
