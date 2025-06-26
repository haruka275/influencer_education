<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>新規ユーザー登録画面</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="login-area">
            <a href="{{ route('admin.show.login') }}">ログインはこちら</a>
        </div>

        <div class="register-body">
            <h2>新規ユーザー登録画面</h2>

            <form class="register-form" method="POST" action="{{ route('admin.show.register') }}">
                @csrf
            <div class="register-form-group">
                <label>ユーザーネーム<input type="text" name="name" required></label>
                @if ($errors->has('name'))
                    <p class="error-message">{{$errors->first('name')}}</p>
                @endif
            </div>
            <div class="register-form-group">
                <label>カナ<input type="text" name="kana" required></label>
                @if ($errors->has('kana'))
                    <p class="error-message">{{$errors->first('kana')}}</p>
                @endif
            </div>
            <div class="register-form-group">
                <label>メールアドレス<input type="email" name="email" required></label>
                @if ($errors->has('email'))
                    <p class="error-message">{{$errors->first('email')}}</p>
                @endif
            </div>
            <div class="register-form-group">
                <label>パスワード<input type="password" name="password" required></label>
                @if ($errors->has('password'))
                    <p class="error-message">{{$errors->first('password')}}</p>
                @endif
            </div>
            <div class="register-form-group">
                <label>パスワード確認<input type="password" name="password_confirmation" required></label>
                @if ($errors->has('password_confirmation'))
                    <p class="error-message">{{$errors->first('password_confirmation')}}</p>
                @endif
            </div>

            <button type="submit">登録</button>
            @if ($errors->has('login'))
                <p class="error-message">{{ $errors->first('login') }}</p>
            @endif
        </form>
</div>
    </body>
</html>

