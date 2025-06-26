<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>トップ画面</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        {{-- 共通ヘッダーを読み込み --}}
        @include('admin.layouts.app') 

        <main>
            <div class="admin-top-body">
            @auth('admin')
                <p>ユーザーネーム：{{ Auth::guard('admin')->user()->name }}</p>{{-- adminガードでログインしている管理者ユーザーの名前取得 --}}
                <p>メールアドレス：{{ Auth::guard('admin')->user()->email }}</p>   

            @else
                <p>ログインしていません。</p>

            @endauth
            </div>
        </main>
    </body>
</html>

