<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
//Authenticatable は Illuminate\Foundation\Auth\Userの別名
//継承することで、AdminモデルはLaravelの認証システムで使えるユーザークラスになる
//Authenticatable は内部で Model を継承している

//Adminクラスはログイン機能が使えるクラス(Authenticatable)を継承する(extends)
class Admin extends Authenticatable
{
    //対応するテーブル名・保存先テーブル
    protected $table = 'admins';

    //複数代入（一度に複数の値をまとめてモデルにセットすること）可能なカラム許可制（$fillable）
    protected $fillable = [
        'name',
        'kana',
        'email',
        'password',
    ];

    //JSONなどで表示させたくないカラム
    protected $hidden = [
        'password',
        'remember_token',//ログイン維持に使う秘密のトークン（トークンは秘密にしておく必要がある）
    ];
}