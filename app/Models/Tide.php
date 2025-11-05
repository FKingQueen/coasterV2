<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tide extends Model
{
    use HasFactory;

    protected $fillable = [
        'buoy_id',
        'tide_height_cm',
        'temperature',
    ];

}
