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

    public function updateArticle(array $data): void
   {
    $this->update([
        'title' => $data['title'],
        'posted_date' => $data['posted_date'],
        'article_contents' => $data['article_contents'],
    ]);
    }
}
