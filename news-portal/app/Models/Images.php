<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = ['article_id', 'image_path'];
    
    protected $casts = [
        'path' => 'json',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
