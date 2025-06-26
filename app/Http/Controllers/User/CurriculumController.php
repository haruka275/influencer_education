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
    //定数定義（マジックナンバーの代わり） private:このクラス内のみで使用　const 定数:定数の宣言
    private const COLOR_GROUP_LOW = 1; //小学生
    private const COLOR_GROUP_MID = 2; //中学生
    private const COLOR_GROUP_HIGH = 3; //高校生

    //学年一覧取得
    private function getGrades()
    {
        //昇順
        return Grade::orderBy('id')->get();
    }

    //ログインユーザーの学年ID取得
    private function getUserGradeId(): ?int
    {
        return auth()->user()->grade_id ?? null;
    }

    //学年IDに応じた色グループを返すメソッド
    private function getColorGroupByGradeId(int $gradeId): int 
    {

        if ($gradeId >= 1 && $gradeId <= 6) {
            return self::COLOR_GROUP_LOW;
        } elseif ($gradeId >= 7 && $gradeId <= 9) {
            return self::COLOR_GROUP_MID;
        } elseif ($gradeId >= 10 && $gradeId <= 12) {
            return self::COLOR_GROUP_HIGH;
        } else {
            return self::COLOR_GROUP_LOW; // デフォルト（小学生）
        }
    }

    //前後月と月初・月末を含む配列を返す
    private function getMonthBoundaries(Carbon $month): array
    {
        return [
            'start' => $month->copy()->startOfMonth(),
            'end' => $month->copy()->endOfMonth(),
            'prev' => $month->copy()->subMonth()->format('Y-m'),
            'next' => $month->copy()->addMonth()->format('Y-m'),
        ];
    }

    //ログインユーザーの学年までをアクティブにしたID配列を返す
    private function getActiveGradeIds($grades, $userGradeId):array
    {
        // アクティブ化する学年IDを初期化
        $activeGradeIds = [];

        if ($userGradeId === null) {
            // ユーザーの学年未設定なら一番下の学年だけアクティブにする
            if ($grades->isNotEmpty()) {
                $activeGradeIds[] = $grades->first()->id;
            }
        } else {
            // ユーザーの学年以下の学年をすべてアクティブにする
            foreach ($grades as $grade) {
                if ($grade->id <= $userGradeId) {
                    $activeGradeIds[] = $grade->id;
                } else {
                    break;
                }
            }
        }

        return $activeGradeIds;
    }

    //学年の選択
    private function getSelectedGrade($grades, $activeGradeIds, ?int $gradeIdFromRequest): ?Grade
    {
        // クエリパラメータから学年IDを取得（未指定なら最初の active 学年）
         $selectedGradeId = $gradeIdFromRequest ?? $activeGradeIds[0] ?? $grades->first()?->id;
         return Grade::find($selectedGradeId);
    }

    //月の処理
    private function getDisplayMonthData(?string $monthStr): array
    {
        $displayMonth = $monthStr ? Carbon::parse($monthStr) : Carbon::now();
        $monthData = $this->getMonthBoundaries($displayMonth);
        return array_merge(['displayMonth' => $displayMonth], $monthData);
    }

    //カリキュラム取得
    private function getCurriculums(int $gradeId, Carbon $start, Carbon $end)
    {
        return Curriculum::forGradeAndMonth($gradeId, $start, $end)->get();
    }

    //配信時間取得 全配信時間（今後の処理で使うなら）
    private function getDeliveryTimes()
    {
        return DeliveryTime::all();
    }
    
    // 色クラス取得
    private function getColorClass(int $gradeId): string
    {
        return 'grade-color-' . $this->getColorGroupByGradeId($gradeId);
    }

    private function enrichCurriculumsWithDeliveryTimes($curriculums)
    {
        foreach ($curriculums as $curriculum) {
            $formatted = [];

            if (!empty($curriculum->deliveryTime)) {
                foreach ($curriculum->deliveryTime as $delivery) {
                    $from = Carbon::parse($delivery->delivery_from);
                    $to = Carbon::parse($delivery->delivery_to);

                    while ($from->lte($to)) {
                        $dayStart = $from->copy()->startOfDay();
                        $dayEnd = $from->copy()->endOfDay();
                        $startTime = $from->greaterThan($dayStart) ? $from : $dayStart;
                        $endTime = $to->lessThan($dayEnd) ? $to : $dayEnd;

                        $formatted[] = [
                            'start' => $startTime,
                            'end' => $endTime,
                        ];

                        $from = $from->copy()->addDay()->startOfDay();
                    }   
                }
            }

            $curriculum->formattedDeliveries = $formatted;
        }

        return $curriculums;
    }

    //カリキュラム一覧ページ表示
    public function showCurriculumList(Request $request)
    {
        $grades = $this->getGrades();

        //各学年に色クラスを追加
        $grades = $grades->map(function($grade) {
            $colorGroup = $this->getColorGroupByGradeId($grade->id);
            $grade->colorClass = 'grade-color-' . $colorGroup;
            return $grade;
        });

        $userGradeId = $this->getUserGradeId();
        $activeGradeIds = $this->getActiveGradeIds($grades, $userGradeId);

        $selectedGrade = $this->getSelectedGrade($grades, $activeGradeIds, $request->input('grade_id'));
        $monthData = $this->getDisplayMonthData($request->input('month'));
        $curriculums = $this->getCurriculums($selectedGrade->id, $monthData['start'], $monthData['end']);
        $deliveryTimes = $this->getDeliveryTimes();

        $selectedColorClass = $this->getColorClass($selectedGrade->id);

        $curriculums = $this->getCurriculums($selectedGrade->id, $monthData['start'], $monthData['end']);
        $curriculums = $this->enrichCurriculumsWithDeliveryTimes($curriculums);

        return view('user.curriculum_list', [
            'displayMonth' => $monthData['displayMonth'],
            'grades' => $grades,
            'curriculums' => $curriculums,
            'delivery_times' => $deliveryTimes,
            'selectedGrade' => $selectedGrade,
            'activeGradeIds' => $activeGradeIds,
            'prevMonth' => $monthData['prev'],
            'nextMonth' => $monthData['next'],
            'selectedColorClass' => $selectedColorClass,
            'startOfMonth' => $monthData['start'],
            'endOfMonth' => $monthData['end'],
        ]);
    }

    //月切り替えHTML生成の専用関数
    private function renderMonthSwitcher(Grade $selectedGrade, Carbon $displayMonth, array $monthData)
    {
        // 色クラスを計算
        $selectedColorClass = $this->getColorClass($selectedGrade->id);

        return view('user.month_switcher_partial', [
            'selectedGrade' => $selectedGrade,
            'displayMonth' => $displayMonth,
            'prevMonth' => $monthData['prev'],
            'nextMonth' => $monthData['next'],
            'selectedColorClass' => $selectedColorClass, 
        ])->render();
    }

    private function getMonthData(?string $monthStr): array
    {
        $displayMonth =$monthStr ? Carbon::parse($monthStr): Carbon::now();
        return array_merge(['displayMonth' => $displayMonth], $this->getMonthBoundaries($displayMonth));
    }

    private function getCurriculumsForRequest(Request $request): array
    {
        $gradeId = $request->input('grade_id');
        $monthData = $this->getMonthData($request->input('month'));
        $curriculums = $this->getCurriculums($gradeId, $monthData['start'], $monthData['end']);
        $grade = Grade::find($gradeId);

        $curriculums = $this->enrichCurriculumsWithDeliveryTimes($curriculums);

        return compact('curriculums', 'grade', 'monthData');
    }

    //カリキュラム一覧（Ajax用）
    public function showCurriculumListPartial(Request $request)
    {
        ['curriculums' => $curriculums, 'grade' => $selectedGrade, 'monthData' => $monthData] =
            $this->getCurriculumsForRequest($request);

        $displayMonth = $monthData['displayMonth']; 

        // ビューの一部だけ返す
        $html = view('user.curriculum_list_partial',  [
            'curriculums' => $curriculums,
            'displayMonth' => $displayMonth,
            'prevMonth' => $monthData['prev'],
            'nextMonth' => $monthData['next'],
        ])->render();

        $monthSwitcherHtml = $this->renderMonthSwitcher($selectedGrade, $displayMonth, $monthData);

        return response()->json([
            'html' => $html,
            'monthSwitcherHtml' => $monthSwitcherHtml,
        ]);
    }

    //配信詳細表示
    public function showDelivery($id)
    {
        $curriculum = Curriculum::with('deliveryTime')->findOrFail($id);

        // 必要に応じてビューに渡す変数を準備
        return view('user.delivery', compact('curriculum'));
    }

}