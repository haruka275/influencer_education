<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//モデルの基底クラス」を読み込むための宣言

class Curriculum extends Model
{
    protected $table = 'curriculums';

    // ホワイトリスト：保存を許可するカラム名を指定（セキュリティ対策）
    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'video_url',
        'alway_delivery_flg',
        'grade_id',
    ];

    //リレーション（関連付け）の定義（多対一）
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    //belongsTo は、「このモデルが他のモデルの子である」ことを示します。「このモデルは Grade モデルに属している」
    //Grade::class は 'App\Models\Grade' を意味
    //grade()はリレーションメソッド名

    //リレーション（関連付け）の定義（一対多）
    public function deliveryTime()
    {
        return $this->hasMany(deliveryTime::class,'curriculums_id');
    }
}
