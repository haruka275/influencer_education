<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Curriculum;

class CurriculumProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userGradeId = $user->grade_id;

        // ユーザーの学年以下のカリキュラムを取得
        $curriculums = Curriculum::with([
            'grade',
            'progress' => function ($query) use ($user) {
                $query->where('user_id', $user->id);  // 自分の進捗のみ
            }
        ])
        ->where('grade_id', '<=', $userGradeId)
        ->orderBy('grade_id')        // 学年順
        ->orderBy('id')              // カリキュラム順（任意）
        ->get();

        // 学年ごとにグルーピング（Bladeでループしやすくする）
        $curriculums_by_grade = $curriculums->groupBy(function ($curriculum) {
            return $curriculum->grade->name ?? '未分類';
        });

        return view('user.curriculum_progress.index', compact(
            'curriculums_by_grade',
            'user',
            'userGradeId'
        ));
    }
}
