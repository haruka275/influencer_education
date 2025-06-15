<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\Admin\StoreNoticeRequest;
use App\Http\Requests\Admin\UpdateNoticeRequest;

class NoticeController extends Controller
{
    // 一覧画面
    public function index()
    {
        // 管理者向け：全記事取得（公開期間などの制限なし）
        $articles = Article::orderBy('posted_date', 'desc')->get();

        return view('admin.notice.index', compact('articles'));
    }

    // 新規作成画面
    public function create()
    {
        return view('admin.notice.create');
    }

    // 保存処理
    public function store(StoreNoticeRequest $request)
    {
        $validated = $request->validated();

        Article::create([
            'title' => $validated['title'],
            'posted_date' => $validated['posted_date'],
            'article_contents' => $validated['article_contents'],
        ]);

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを登録しました');
    }

    // 編集画面表示
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('admin.notice.edit', compact('article'));
    }

    // 更新処理（←ここが今回の修正ポイント）
    public function update(UpdateNoticeRequest $request, $id)
    {
        $article = Article::findOrFail($id);

        // モデル内メソッドで更新処理
        $article->updateArticle($request->validated());

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを更新しました');
    }

    // 削除処理
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを削除しました');
    }
}
