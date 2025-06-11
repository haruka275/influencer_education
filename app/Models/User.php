<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Grade;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'password',
        'profile_image',
        'grade_id',
    ];

    /**
     * 非表示にする属性（配列）
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * キャスト（型変換）
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * リレーション：学年
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
