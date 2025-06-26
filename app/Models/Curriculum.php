<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//モデルの基底クラス」を読み込むための宣言
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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

    //laravelのEloquentモデルにおけるクエリスコープを使って学年と月でカリキュラムを絞り込む処理を共通化している
    public function scopeForGradeAndMonth(Builder $query, int $gradeId, carbon $startOfMonth, Carbon $endOfMonth): Builder
    {
        return $query->with('deliveryTime')//配信時間テーブルも一緒に読み込む(Eager Load) Curriculum::with('deliveryTime)と同義
        ->where('grade_id', $gradeId)//子の学年のカリキュラムに絞る
        //常時公開か配信期間が月にかぶっているものを取得
        ->where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('alway_delivery_flg', true)//常時公開
                ->orwhereHas('deliveryTime', function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])//月内で始まる
                        ->orwhereBetween('delivery_to', [$startOfMonth, $endOfMonth]);
                });
        });
    }
    
}
