<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\UserUpdateProfileRequest;

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
    public function update(UserUpdateProfileRequest $request)
    {
        $user = Auth::user();

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
        $user->name = $request->input('name');
        $user->name_kana = $request->input('name_kana');
        $user->email = $request->input('email');
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'プロフィールを更新しました。');
    }
}
