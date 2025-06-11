<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;
use App\Models\CurriculumProgress;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    // リレーション：学年
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // リレーション：このカリキュラムに対する進捗（ログイン中のユーザー1人分）
    public function progress()
    {
        return $this->hasOne(CurriculumProgress::class)
                    ->where('user_id', auth()->id()); // ここでログインユーザーに限定
    }
}
