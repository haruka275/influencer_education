<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>管理画面ログイン</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="register-area">
            <a class="btn-register" href="{{ route('admin.show.register') }}">新規会員登録はこちら</a>
        </div>

        <div class="login-body">
            <h2>管理画面ログイン</h2>

            <form class="login-form" method="POST" action="{{ route('admin.show.login') }}">
                @csrf
                    <div class="login-form-group">
                        <label>メールアドレス<input type="email" name="email" value="{{ old('email') }}" required autofocus>
                        </label>
                        @if ($errors->has('email'))
                            <p class="error-message">{{$errors->first('email')}}</p>
                        @endif
                    </div>

                    <div class="login-form-group">
                        <label>パスワード<input type="password" name="password" required></label>
                        @if ($errors->has('password'))
                            <p class="error-message">{{$errors->first('password')}}</p>
                    @endif
                    </div>

                <button type="submit">ログイン</button>
                @if ($errors->has('login'))
                    <p class="error-message">{{ $errors->first('login') }}</p>
                @endif
            </form>
        </div>
    </body>
</html>

