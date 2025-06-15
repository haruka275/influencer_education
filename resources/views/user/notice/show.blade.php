@extends('layouts.app')

@section('content')
<style>
    .nav-red {
        background-color: #ff4d4d;
        padding: 10px;
        margin-bottom: 20px;
    }
</style>

<div class="container">

    {{-- 上部ナビゲーション --}}
    <div class="nav-red d-flex justify-content-between align-items-center">
        <div class="d-flex">
            <a href="#" class="btn text-white me-2" style="background-color: #00BFFF;">時間割</a>
            <a href="#" class="btn text-white me-2" style="background-color: #00BFFF;">授業進捗</a>
            <a href="#" class="btn text-white" style="background-color: #00BFFF;">プロフィール設定</a>
        </div>
        <div>
            <span class="text-dark">ログアウト</span>
        </div>
    </div>

    {{-- →戻るリンク --}}
    <div class="mb-3">
        <a href="{{ route('user.notice.index') }}" class="text-dark" style="text-decoration: none;">→戻る</a>
    </div>

    {{-- 公開開始日（未設定対応のみ） --}}
    <p class="text-muted">
    {{ $article->posted_date ? \Carbon\Carbon::parse($article->posted_date)->format('Y年m月d日') : '未設定' }}
    </p>

    {{-- タイトル --}}
    <div class="mb-3">
        <h2 class="fw-bold">{{ $article->title }}</h2>
    </div>

    {{-- 本文 --}}
    <textarea class="form-control" rows="12" readonly>{{ $article->article_contents }}</textarea>

</div>
@endsection
