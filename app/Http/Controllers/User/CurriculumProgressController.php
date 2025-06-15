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

        // 全カリキュラムを取得（←ここが講師の指摘対応）
        $curriculums = Curriculum::with([
            'grade',
            'progress' => function ($query) use ($user) {
                $query->where('user_id', $user->id);  // 自分の進捗のみ
            }
        ])
        ->orderBy('grade_id') // 学年順
        ->orderBy('id')       // 任意：ID順
        ->get();

        // Bladeで使いやすいように学年ごとにグループ化
        $curriculums_by_grade = $curriculums->groupBy(function ($curriculum) {
            return $curriculum->grade->name ?? '未分類';
        });

        return view('user.curriculum_progress.index', compact(
            'curriculums_by_grade',
            'user'
        ));
    }
}
