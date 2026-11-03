<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'author',
        'category',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
