<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = ['article_id', 'user_id', 'content'];
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
