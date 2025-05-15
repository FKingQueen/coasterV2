<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuoyVersionTwo extends Model
{
    use HasFactory;

    protected $fillable = [
        'buoy_id',
        'SWH',
        'AWP',
        'Temp',
        'Year',
        'Month',
        'Day',
        'Hour',
        'Min',
    ];
}
