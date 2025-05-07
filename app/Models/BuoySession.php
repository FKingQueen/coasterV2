<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuoySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'year',
        'day_of_year',
        'minute_of_day',
    ];
}
