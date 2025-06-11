<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curriculum;
use App\Models\User;

class CurriculumProgress extends Model
{
    use HasFactory;

    protected $table = 'curriculum_progresses';

    // リレーション：カリキュラム
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    // リレーション：ユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
