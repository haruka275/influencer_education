<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * プロフィール編集画面の表示
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 入力バリデーション
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー　]+$/u'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'name.required' => '名前は必須です。',
            'name.max' => '名前は255文字以内で入力してください。',
            'name_kana.required' => 'カナは必須です。',
            'name_kana.max' => 'カナは255文字以内で入力してください。',
            'name_kana.regex' => 'カナは全角カタカナで入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'profile_image.image' => '画像ファイルを選択してください。',
            'profile_image.mimes' => '画像はjpgまたはpng形式である必要があります。',
            'profile_image.max' => '画像サイズは2MB以内にしてください。',
            'current_password.required' => '現在のパスワードを入力してください。',
            'new_password.required' => '新しいパスワードを入力してください。',
            'new_password.min' => 'パスワードは8文字以上で入力してください。',
            'new_password.confirmed' => '新しいパスワードが一致しません。',
        ]);

        // 現在のパスワードが一致するか確認
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()
                ->withErrors(['current_password' => '現在のパスワードが一致しません。'])
                ->withInput();
        }

        // プロフィール画像がアップロードされた場合
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // データを更新
        $user->name = $validated['name'];
        $user->name_kana = $validated['name_kana'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'プロフィールを更新しました。');
    }
}
