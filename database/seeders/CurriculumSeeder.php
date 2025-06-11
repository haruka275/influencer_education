<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curriculum;

class CurriculumSeeder extends Seeder
{
    public function run()
    {
        // 学年ごとに3つずつ授業を登録（例）
        foreach ([1, 2, 3] as $gradeId) {
            for ($i = 1; $i <= 3; $i++) {
                Curriculum::create([
                    'title' => "【{$gradeId}年】サンプル授業 {$i}",
                    'thumbnail' => "thumb_{$gradeId}_{$i}.jpg",
                    'grade_id' => $gradeId,
                ]);
            }
        }
    }
}
