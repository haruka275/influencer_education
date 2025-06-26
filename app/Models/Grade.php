<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//モデルの基底クラス」を読み込むための宣言

class Grade extends Model
{
    protected $table = 'grades';

    protected $fillable = ['name'];
}