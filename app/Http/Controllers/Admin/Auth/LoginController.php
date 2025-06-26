<?php

//LoginControllerクラスのある場所
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;//laravelの基本的なコントローラーの親クラス
use App\Models\Admin;//Adminモデル（管理者のDBモデル）
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;//フォームからのリクエストデータを扱う
use Illuminate\Support\Facades\Auth;//認証処理を行うためのクラス
use Illuminate\View\View;


class LoginController extends Controller
{
    //showLoginFormメソッド
    //管理者ログイン画面を表示する処理
    public function showLoginForm():View
    {
        return view('admin.auth.login');
    }

    //loginメソッド 
    //ログイン処理
    public function store(LoginRequest $request): RedirectResponse

    {
        $request->validate([
            //ルールの明記
            'email' => ['required' ,'email'],
            'password' => ['required' ,'string' ,'min:8'],
        ],[
            //エラーメッセージ指定
            'email.email' => '有効なメールアドレスの形式で入力してください',
            'password.min' => 'パスワードは8文字以上で入力してください',
        ]);

        //フォームから送られてきた email と password を $credentials にまとめる。
        $credentials = $request->only('email','password');

        //入力されたメールアドレスとパスワードが正しいかチェック
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            //認証成功
            return redirect()->intended('/admin/top');
        }
        
        //認証失敗
        return back()->withErrors([
            'login' => 'メールアドレスまたはパスワードが正しくありません',
        ])->withInput($request->only('email'));
    }    
    
    //ログアウト処理--いらないかも--
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();//Laravelの認証機能の中の「webガード」を使って、ユーザーをログアウトさせる
        $request->session()->invalidate();//セッション（ユーザーのログイン情報などのデータ）を無効にして、古い情報をすべてクリア
        $request->session()->regenerateToken();//CSRFトークン（フォームのセキュリティを守る仕組み）を新しく作り直すす
        
        return redirect()->route('admin.show.login'); // 管理者ログイン画面にリダイレクト
    }
}



