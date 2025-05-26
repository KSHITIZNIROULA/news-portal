<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    
    protected $fillable=['title','slug','content','author_id','published_at','images','status'];

   protected $casts=[
    'published_at'=>'datetime',
    'images'=>'array',
   ];
    
   public function category(){
    return $this->belongsTo(Category::class);
   }
   
   public function author(){
    return $this->belongsTo(User::class,'author_id');
   }

    public function image()
    {
        return $this->hasMany(Images::class);
    }
}
