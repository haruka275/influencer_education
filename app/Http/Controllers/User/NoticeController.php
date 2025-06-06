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

        $articles = Article::where('user_flag', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('user.notice.index', compact('articles'));
    }

    public function show($id)
    {
        $now = Carbon::now();

        $article = Article::where('id', $id)
            ->where('user_flag', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->firstOrFail();

        return view('user.notice.show', compact('article'));
    }
}
