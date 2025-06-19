<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\DeliveryTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    //public：他のクラスやコントローラーからも呼び出せる
    //function showCurriculumList():showCurriculumList という名前の関数（メソッド）を定義
    //カリキュラム一覧ページを表示する処理 コントローラーから変数を渡す
    public function showCurriculumList(Request $request)
    {
        //学年一覧取得
            $grades = Grade::all();

    // --- 仮のデータ：学年ごとのカリキュラムクリア状況（ユーザー単位で取得する）---
    // 例えば下記のような形式で取得している想定（Grade ID => クリア済みかどうか）
    $clearedCurriculumsByGrade = [
        1 => true,
        2 => true,
        3 => false,
        4 => false,
    ];

    /*全学年を活性化（全IDを配列に入れる）
    $activeGradeIds = $grades->pluck('id')->toArray();
    */

    // アクティブ化する学年IDを初期化
    $activeGradeIds = [];

    // ロジック：連続するクリア済み学年＋次の学年を1つだけ活性化
    $addedCurrent = false;

    foreach ($grades as $grade) {
        $gradeId = $grade->id;

        if (isset($clearedCurriculumsByGrade[$gradeId]) && $clearedCurriculumsByGrade[$gradeId]) {
            $activeGradeIds[] = $gradeId; // クリア済み学年は活性
        } elseif (!$addedCurrent) {
            $activeGradeIds[] = $gradeId; // 最初の未クリア学年が「現在の学年」になる
            $addedCurrent = true;
        } else {
            break; // それ以降は非活性（グレーアウト）
        }
    }

    // クエリパラメータから学年IDを取得（未指定なら最初の active 学年）
    $selectedGradeId = $request->input('grade_id') ?? $activeGradeIds[0] ?? $grades->first()?->id;
    $selectedGrade = Grade::find($selectedGradeId);

    // 月の処理
    $displayMonth = $request->input('month')
        ? Carbon::parse($request->input('month'))
        : Carbon::now();

    $startOfMonth = $displayMonth->copy()->startOfMonth();
    $endOfMonth = $displayMonth->copy()->endOfMonth();

    // ◀▶に必要な月も定義
$prevMonth = $displayMonth->copy()->subMonth()->format('Y-m');
$nextMonth = $displayMonth->copy()->addMonth()->format('Y-m');


    // カリキュラム取得（学年＋配信期間条件）
$curriculums = Curriculum::with('deliveryTime')
    ->where('grade_id', $selectedGradeId)
    ->where(function ($query) use ($startOfMonth, $endOfMonth) {
        $query->where('alway_delivery_flg', true)
              ->orWhereHas('deliveryTime', function ($q) use ($startOfMonth, $endOfMonth) {
                  $q->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth]);
              });
    })
    ->get();

    // 全配信時間（今後の処理で使うなら）
    $delivery_times = DeliveryTime::all();

    // ↓ここから色クラス計算を入れる
$gradeId = $selectedGrade->id;
if ($gradeId >= 1 && $gradeId <= 6) {
    $selectedColorGroup = 1;
} elseif ($gradeId >= 7 && $gradeId <= 9) {
    $selectedColorGroup = 2;
} elseif ($gradeId >= 10 && $gradeId <= 12) {
    $selectedColorGroup = 3;
} else {
    $selectedColorGroup = 1;
}
$selectedColorClass = 'grade-color-' . $selectedColorGroup;

    return view('user.curriculum_list', compact(
        'displayMonth', 'grades', 'curriculums', 'delivery_times',
        'selectedGrade', 'activeGradeIds', 'prevMonth', 'nextMonth', 'selectedColorClass'
    ));
}
public function showCurriculumListPartial(Request $request)
{
    $gradeId = $request->input('grade_id');
    $month = $request->input('month');

    // 月の期間設定
    $displayMonth = $month ? Carbon::parse($month) : Carbon::now();
    $startOfMonth = $displayMonth->copy()->startOfMonth();
    $endOfMonth = $displayMonth->copy()->endOfMonth();

    // カリキュラム取得
    $curriculums = Curriculum::with('deliveryTime')
    ->where('grade_id', $gradeId)
    ->where(function ($query) use ($startOfMonth, $endOfMonth) {
        $query->where('alway_delivery_flg', true)
              ->orWhereHas('deliveryTime', function ($q) use ($startOfMonth, $endOfMonth) {
                  $q->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth]);
              });
    })
    ->get();

    // ビューの一部だけ返す
    $html = view('user.curriculum_list_partial',  [
    'curriculums' => $curriculums,
    'prevMonth' => $displayMonth->copy()->subMonth()->format('Y-m'),
    'nextMonth' => $displayMonth->copy()->addMonth()->format('Y-m'),
    'displayMonth' => $displayMonth,
])->render();

$selectedGrade = Grade::find($gradeId);

 // 月切り替え部分のHTMLも生成する（部分テンプレートとして切り出している想定）
    $monthSwitcherHtml = view('user.month_switcher_partial', [
        'prevMonth' => $displayMonth->copy()->subMonth()->format('Y-m'),
        'nextMonth' => $displayMonth->copy()->addMonth()->format('Y-m'),
        'displayMonth' => $displayMonth,
        'selectedGrade' => $selectedGrade,
    ])->render();

    return response()->json([
        'html' => $html,
        'monthSwitcherHtml' => $monthSwitcherHtml,
    ]);
}
}