<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;//モデルの基底クラス」を読み込むための宣言

class DeliveryTime extends Model
{
    protected $table = 'delivery_times';

    protected $fillable = [
        'curriculums_id',
        'delivery_from',
        'delivery_to',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}