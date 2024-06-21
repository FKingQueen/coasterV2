<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bouy extends Model
{
    use HasFactory;

    protected $fillable = [
        'bouy_id',
        'wave_height',
        'tide_height',
        'wave_period',
        'wave_power',
        'wave_temparature',
        'air_temparature',
    ];
}
