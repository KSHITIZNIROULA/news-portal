<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Subscription.php
class Subscription extends Model
{
    protected $fillable = ['user_id', 'publisher_id', 'subscribed_at', 'expires_at', 'status'];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }
}
