<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'author_id', 'published_at','status','is_exclusive'];
    
    protected $casts=[
        'published_at' => 'datetime',
        'status' => 'string',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
