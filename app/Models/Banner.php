<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//モデルの基底クラス」を読み込むための宣言

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = ['image'];
}