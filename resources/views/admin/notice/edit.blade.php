@extends('layouts.app')

@section('content')
<style>
    .admin-header {
        background-color: #87CEFA; /* 水色 */
        padding: 15px 0;
    }
    .admin-header .inner {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-header .menu {
        display: flex;
        gap: 15px;
    }
    .admin-header .menu a {
        background-color: gray;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 5px;
    }
    .admin-header .logout-link {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }
    .back-link {
        color: black;
        text-decoration: underline;
        margin: 20px 0;
        display: inline-block;
    }
    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
    }
    .form-control, textarea {
        width: 100%;
    }
    .center-button {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }
    .gray-button {
        background-color: gray;
        color: white;
        border: none;
        padding: 10px 30px;
        border-radius: 5px;
    }
</style>

<div class="admin-header">
    <div class="container">
        <div class="inner">
            <div class="menu">
                <a href="#">授業管理</a>
                <a href="#">お知らせ管理</a>
                <a href="#">バナー管理</a>
            </div>
            <div>
                <a href="{{ route('logout') }}"
                   class="logout-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <a href="{{ route('admin.notice.index') }}" class="back-link">← 戻る</a>

    <div class="form-container">
        <h2 class="mb-4">お知らせ変更</h2>

        <form action="{{ route('admin.notice.update', $article->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="posted_date" class="form-label">投稿日時</label>
                <input type="datetime-local" name="posted_date" id="posted_date" class="form-control"
                value="{{ old('posted_date', \Carbon\Carbon::parse($article->posted_date)->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}">
            </div>

            <div class="mb-3">
                <label for="article_contents" class="form-label">本文</label>
                <textarea name="article_contents" id="article_contents" class="form-control" rows="6">{{ old('article_contents', $article->article_contents) }}</textarea>
            </div>

            <div class="center-button">
                <button type="submit" class="gray-button">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
