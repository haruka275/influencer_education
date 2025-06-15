@extends('layouts.app')

@section('content')
<div class="admin-header">
    <div class="container">
        <div class="inner">
            <div class="menu">
                <a href="#">授業管理</a>
                <a href="#">お知らせ管理</a>
                <a href="#">バナー管理</a>
            </div>
            <div>
                <a href="{{ route('logout') }}" class="logout-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <a href="{{ route('admin.notice.index') }}" class="back-link">← 戻る</a>

    <div class="form-container">
        <h2 class="mb-4">お知らせ新規登録</h2>

        <form action="{{ route('admin.notice.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="posted_date" class="form-label">投稿日時</label>
                <input type="text" name="posted_date" id="posted_date" class="form-control" value="{{ old('posted_date') }}">
                @error('posted_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="article_contents" class="form-label">本文</label>
                <textarea name="article_contents" id="article_contents" class="form-control" rows="6">{{ old('article_contents') }}</textarea>
                @error('article_contents')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="center-button">
                <button type="submit" class="gray-button">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection
