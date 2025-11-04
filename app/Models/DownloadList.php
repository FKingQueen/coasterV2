<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadList extends Model
{
    use HasFactory;

        protected $fillable = [
        'id',
        'download_id',
        'name',
    ];

    public function download()
    {
        return $this->belongsTo(Download::class);
    }
}
