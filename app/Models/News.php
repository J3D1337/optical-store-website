<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = ['title',
        'content',
        'images',
    ];
}
