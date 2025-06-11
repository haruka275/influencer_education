<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'article_contents',
        'posted_date',
        'start_date',
        'end_date',
        'user_flag',
    ];

    protected $dates = [
        'posted_date',
        'start_date',
        'end_date',
    ];
}
