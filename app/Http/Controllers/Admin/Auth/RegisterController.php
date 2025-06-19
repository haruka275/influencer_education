<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;//Adminモデル（管理者のDBモデル）
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;//Request（HTTPリクエストを扱う）
use Illuminate\Support\Facades\Auth;//Auth（認証処理）
use Illuminate\Support\Facades\Hash;//Hash（パスワードのハッシュ化=暗号化）
use Illuminate\Validation\Rules;//Rules（バリデーションルール）
use Illuminate\View\View;//View（ビューの型指定）

class RegisterController extends Controller
{

    //新規登録画面表示
    public function showRegisterForm(): View
    {
        return view('admin.auth.register');
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string', 
                'max:255',
                'regex:/^[^\x01-\x7E\xA1-\xDF]+$/u', // 全角文字チェック
                'unique:admins,name',
            ],
            'kana' => [
                'required',
                'string',
                'max:255',
                'regex:/^[ァ-ヶー　]+$/u', // 全角カタカナと全角スペースのみ
            ],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:admins,email',
            ],
            'password' => [
                'required', 
                'string',
                'min:8',
                'max:255',
                'confirmed',//確認用password_confirmationと一致
            ],
            ],[
            'name.required' => 'ユーザーネームが入力されていません',
            'name.regex' => 'ユーザーネームは全角で入力してください',
            'kana.required' => 'カナが入力されていません',
            'kana.regex' => 'カナは全角カタカナで入力してください',
            'email.required' => 'メールアドレスが入力されていません',
            'email.email' =>'メールアドレスは正しいメール形式で入力してください',
            'password.required' => 'パスワードが入力されていません',
            'password.min' => 'パスワードは８文字以上で入力してください',
            'password.confirmed' => '確認用パスワードが一致ししません',
            'password_confirmation.required' => '確認用パスワードを入力してください',
        ]);

        //新しい管理者レコードをデータベースに追加
        $admin = Admin::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        event(new Registered($admin));
        
        //登録した管理者ユーザーをそのまま管理者用の認証ガードでログイン
        Auth::guard('admin')->login($admin);//guard('admin')は複数ユーザー（一般ユーザーと管理者など)を扱う場合の切り替え機能

        return redirect('admin/top');
    }
}
