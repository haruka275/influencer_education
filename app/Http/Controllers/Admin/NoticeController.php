<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class NoticeController extends Controller
{
    public function index()
    {
        // 管理者向け：全記事取得（公開期間などの制限なし）
        $articles = Article::orderBy('start_date', 'desc')->get();
        return view('admin.notice.index', compact('articles'));
    }

    public function create()
    {
        // お知らせ新規登録画面（未作成でもビュー名合わせればOK）
        return view('admin.notice.create');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.notice.edit', compact('article'));
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを削除しました');
    }
}
