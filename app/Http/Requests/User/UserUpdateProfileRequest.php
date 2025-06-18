<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserUpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 認証済みユーザーのみ許可
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ユーザーネームは必須です。',
            'name_kana.required' => 'カナは必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'profile_image.image' => 'プロフィール画像は画像ファイルである必要があります。',
            'profile_image.mimes' => 'プロフィール画像は jpeg, png, jpg, gif のいずれかの形式で指定してください。',
            'profile_image.max' => 'プロフィール画像のサイズは2MB以下にしてください。',
            'current_password.required_with' => 'パスワードを変更する場合は、現在のパスワードが必要です。',
            'current_password.current_password' => '現在のパスワードが正しくありません。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ];
    }
}
