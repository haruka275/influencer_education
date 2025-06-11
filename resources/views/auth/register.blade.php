@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- ユーザー名 --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- ユーザー名カナ --}}
                        <div class="row mb-3">
                            <label for="name_kana" class="col-md-4 col-form-label text-md-end">{{ __('Name Kana') }}</label>
                            <div class="col-md-6">
                                <input id="name_kana" type="text"
                                    class="form-control @error('name_kana') is-invalid @enderror" name="name_kana"
                                    value="{{ old('name_kana') }}" required autocomplete="name_kana">
                                @error('name_kana')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- メールアドレス --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- パスワード --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- パスワード確認 --}}
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- 学年（grade_id） --}}
                        <div class="row mb-3">
                            <label for="grade_id" class="col-md-4 col-form-label text-md-end">{{ __('Grade') }}</label>
                            <div class="col-md-6">
                                <select id="grade_id" class="form-control @error('grade_id') is-invalid @enderror" name="grade_id" required>
                                    <option value="">選択してください</option>
                                    <option value="1" {{ old('grade_id') == 1 ? 'selected' : '' }}>1年</option>
                                    <option value="2" {{ old('grade_id') == 2 ? 'selected' : '' }}>2年</option>
                                    <option value="3" {{ old('grade_id') == 3 ? 'selected' : '' }}>3年</option>
                                </select>
                                @error('grade_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- 登録ボタン --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
