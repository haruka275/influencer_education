<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function showArticleList()
    {
        return view('admin.article_list');
    }
}