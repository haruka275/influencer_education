<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CurriculumProgress;
use App\Models\Curriculum;
use App\Models\User;

class CurriculumProgressSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // 最初のユーザー
        $userGradeId = $user->grade_id;

        // 同じ学年以下のカリキュラムに進捗データを付与
        $curriculums = Curriculum::where('grade_id', '<=', $userGradeId)->get();

        foreach ($curriculums as $curriculum) {
            CurriculumProgress::create([
                'user_id' => $user->id,
                'curriculum_id' => $curriculum->id,
                'clear_flg' => rand(0, 1), // 仮データ: 0か1をランダムに
                'last_learned_at' => now()->subDays(rand(1, 30)), // 仮データ：最近の学習日
            ]);
        }
    }
}
