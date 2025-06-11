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
        return view('admin.notice.create');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('admin.notice.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'posted_date' => 'required|date_format:Y-m-d H:i',
            'article_contents' => 'required|string',
        ]);

        // 対象記事を取得
        $article = Article::findOrFail($id);

        // 更新
        $article->update([
            'title' => $validated['title'],
            'posted_date' => $validated['posted_date'],
            'article_contents' => $validated['article_contents'],
        ]);

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを更新しました');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを削除しました');
    }
}
