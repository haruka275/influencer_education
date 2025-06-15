<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Carbon\Carbon;

class NoticeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $articles = Article::orderBy('posted_date', 'desc')->get();

        return view('user.notice.index', compact('articles'));
    }

    public function show($id)
    {
        $now = Carbon::now();

        $article = Article::findOrFail($id);

        return view('user.notice.show', compact('article'));
    }
}
