<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleProject extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'project_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
