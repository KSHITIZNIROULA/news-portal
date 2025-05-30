<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['article_id', 'path'];
    

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
