@extends('layouts.app')

@section('content')
{{-- 赤背景ナビエリア --}}
<div style="background-color: red; padding: 1rem;">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex gap-2">
            <a href="#" class="btn" style="background-color: #00BFFF; color: white;">時間割り</a>
            <a href="#" class="btn" style="background-color: #00BFFF; color: white;">授業進捗</a>
            <a href="{{ route('user.profile.edit') }}" class="btn" style="background-color: #00BFFF; color: white;">プロフィール設定</a>
        </div>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="color: white; text-decoration: none;">ログアウト</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

{{-- 白背景エリア --}}
<div class="container" style="background-color: white; padding: 2rem; border-radius: 8px;">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-link" style="color: black; text-decoration: none;">← 戻る</a>
    </div>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- エラーメッセージ --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3 class="mb-4">プロフィール変更</h3>

    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- プロフィール画像 --}}
        <div class="mb-4">
            <label class="form-label d-block">プロフィール画像</label>
            <div class="d-flex align-items-start gap-3">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" width="120" height="120" class="rounded-circle">
                @else
                    <img src="{{ asset('images/default-profile.png') }}" alt="デフォルト画像" width="120" height="120" class="rounded-circle">
                @endif
                <div class="flex-grow-1">
                    <input type="file" name="profile_image" class="form-control mt-2" style="max-width: 300px;">
                </div>
            </div>
        </div>

        {{-- ユーザーネーム --}}
        <div class="mb-3 d-flex align-items-center">
            <label for="name" class="form-label me-3" style="min-width: 120px;">ユーザーネーム</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        {{-- カナ --}}
        <div class="mb-3 d-flex align-items-center">
            <label for="name_kana" class="form-label me-3" style="min-width: 120px;">カナ</label>
            <input type="text" id="name_kana" name="name_kana" class="form-control" value="{{ old('name_kana', $user->name_kana) }}">
        </div>

        {{-- メールアドレス --}}
        <div class="mb-3 d-flex align-items-center">
            <label for="email" class="form-label me-3" style="min-width: 120px;">メールアドレス</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        {{-- 現在のパスワード --}}
        <div class="mb-3 d-flex align-items-center">
            <label for="current_password" class="form-label me-3" style="min-width: 120px;">現在のパスワード</label>
            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="現在のパスワードを入力">
        </div>
        @error('current_password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- パスワード --}}
        <div class="mb-3 d-flex align-items-center">
           <label for="new_password" class="form-label me-3" style="min-width: 120px;">パスワード</label>
           <input type="password" id="new_password" name="new_password" class="form-control" placeholder="パスワードを変更する">
        </div>
        @error('new_password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- パスワード確認 --}}
        <div class="mb-4 d-flex align-items-center">
           <label for="new_password_confirmation" class="form-label me-3" style="min-width: 120px;">パスワード確認</label>
           <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="もう一度入力">
        </div>
        @error('new_password_confirmation')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- 登録ボタン --}}
        <div class="text-center">
            <button type="submit" class="btn" style="background-color: red; color: white;">登録</button>
        </div>
    </form>
</div>
@endsection
