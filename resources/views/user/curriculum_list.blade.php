<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>授業一覧画面</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        {{-- 共通ヘッダーを読み込み --}}
        {{-- @include('') --}} 

        <main>
            <div class="curriculum_list-month">
                <div class="back-btn-curriculum_list">
                    <a href="/">←戻る</a>
                </div>

                {{-- 月切り替え --}}
                <div class="month" id="month-switcher">
                    
                    @php // ここに普通のPHPコードを書ける
                        $gradeId = $selectedGrade->id; // 「今選ばれている学年のIDだけを $gradeId に取り出して使えるようにする」 $selectedGrade は「選択されている学年の情報を持ったオブジェクト」
                
                        if ($gradeId >= 1 && $gradeId <= 6) {
                            $selectedColorGroup = 1; // $gradeIdが1〜6のとき → 色グループ1を選ぶ
                        } elseif ($gradeId >= 7 && $gradeId <= 9) {
                            $selectedColorGroup = 2; // $gradeIdが7〜9のとき → 色グループ2を選ぶ
                        } elseif ($gradeId >= 10 && $gradeId <= 12) {
                            $selectedColorGroup = 3; // $gradeIdが10〜12のとき → 色グループ3を選ぶ
                        } else {
                            $selectedColorGroup = 1; // デフォルト
                        }
                        $selectedColorClass = 'grade-color-' . $selectedColorGroup; // grade-color-1,2,3
                    @endphp

                    <a href="#" class="month-nav" data-month="{{ $prevMonth }}">◀</a>
                    <h4 style="margin: 0;">
                        {{ $displayMonth->format('Y年m月') }}スケジュール 
                    </h4>
                    <a href="#" class="month-nav" data-month="{{ $nextMonth }}">▶</a>
                    <span id="current-grade" class="select-grade {{ $selectedColorClass }}">
                        {{ $selectedGrade->name }}
                    </span>
                </div>
            </div>                    
            
            <div class="curriculum-layout">
                {{-- 学年切り替え --}}
                <div class="curriculum_list-grade">

                    <ul>
                        @foreach($grades as $index => $grade)
                            @php
                                if ($index <= 5) {   // 0〜5 → 6学年分
                                    $colorGroup = 1;
                                } elseif ($index <= 8) { // 6〜8 → 3学年分
                                    $colorGroup = 2;
                                } else {  // 9以降 → 3学年分
                                    $colorGroup = 3;
                                }
                                $colorClass = 'grade-color-' . $colorGroup;

                                // $activeGradeIds は、アクティブ（選択されている）学年のIDをまとめた配列
                                // in_array($grade->id, $activeGradeIds) で、今の学年がアクティブならtrue、そうでなければfalseを返す。
                                $isActive = in_array($grade->id, $activeGradeIds); // // $activeGradeIds配列の中に今の学年IDがあるかどうかを調べている
                            @endphp

                            <li>
                                <a href="#"
                                    class="grade-link {{ $isActive ? $colorClass : 'disabled' }}"
                                    data-grade-id="{{ $grade->id }}"
                                    data-color-class="{{ $colorClass }}">
                                    {{ $grade->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- 授業サムネイル一覧 --}}
                <div id="curriculum-list">
                    {{-- 親テンプレートから必要な変数を渡して部分テンプレートを差し込む --}}
                    @include('user.curriculum_list_partial', [
                        'curriculums' => $curriculums,
                        'prevMonth' => $prevMonth,
                        'nextMonth' => $nextMonth,
                        'displayMonth' => $displayMonth
                    ])
                </div>
            </div>
        </main>
        <script>
            // でPHP（Blade）のルートURLを取得
            const ajaxUrl = "{{ route('user.curriculum_list_partial') }}";

            // selectedGradeIdをグローバルに宣言
            let selectedGradeId = "{{ $selectedGrade->id }}";

            //ページが読み込まれた時点で「現在選択されている学年のID」を①HTML上でactiveクラスが付いたリンクから取得し、②なければBladeの変数から取得する
            document.addEventListener('DOMContentLoaded', function() {
                // ここに書いた処理は、HTMLの読み込みが終わってから実行される

                // IDが current-grade の要素を取得して currentGrade に格納。
                const currentGrade = document.getElementById('current-grade');

                // 学年ボタン押下時
                document.querySelectorAll('.grade-link:not(.disabled)').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();// リンクのデフォルト動作（ページ遷移）を止める

                        selectedGradeId = this.getAttribute('data-grade-id'); // クリックした学年のIDを取得
                        const gradeName = this.textContent.trim(); // 学年名（テキスト）を取得
                        const colorClass = this.getAttribute('data-color-class'); // 色クラスを取得

                        // 現在表示されている学年表示部分を書き換え
                        currentGrade.textContent = gradeName;
                        currentGrade.classList.remove('grade-color-1', 'grade-color-2', 'grade-color-3');// 古い色クラスを外す
                        currentGrade.classList.add(colorClass);// 新しい色クラスを付ける

                        // 全ての学年リンクの「active」クラスを外す
                        document.querySelectorAll('.grade-link').forEach(link => link.classList.remove('active'));
                        // クリックした学年リンクに「active」クラスを付ける
                        this.classList.add('active');

                        // 選択学年IDと年月を使って授業一覧をAjaxで再取得・再描画する関数を呼び出す
                        fetchAndRenderCurriculums(selectedGradeId, '{{ $displayMonth->format("Y-m") }}');
                    });
                });
                
                // 初回月切り替えイベント登録
                bindMonthNavEvents();
            });


            function bindMonthNavEvents() {
                document.querySelectorAll('.month-nav').forEach(link => {
                    link.removeEventListener('click', monthNavClickHandler); // 可能な重複防止
                    link.addEventListener('click', monthNavClickHandler);
                });
            }

            function rebindMonthEvents() {
                bindMonthNavEvents(); // ← これでOK
            }
            
            function monthNavClickHandler(e) {
                e.preventDefault();
                const month = this.getAttribute('data-month');
                fetchAndRenderCurriculums(selectedGradeId, month);
            }

            // fetch APIで非同期通信
            function fetchAndRenderCurriculums(gradeId, month) {
                fetch(`${ajaxUrl}?grade_id=${gradeId}&month=${month}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.ok ? res.json() : Promise.reject('通信エラー'))
                .then(data => {
                    const list = document.getElementById('curriculum-list');
                    if (list) {
                        list.innerHTML = data.html; // 授業一覧更新
                    }

                    // ✅ 月切り替え部分を ".curriculum_list-month" 丸ごと置き換える
                    const monthContainer = document.querySelector('.curriculum_list-month');
                    if (monthContainer) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.monthSwitcherHtml;

                        const newMonthContainer = tempDiv.querySelector('.curriculum_list-month');
                        if (newMonthContainer) {
                            monthContainer.replaceWith(newMonthContainer); // ← ここがポイント
                            bindMonthNavEvents(); // イベント再バインド
                        }
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('授業一覧の取得に失敗しました。');
                });
            }

        </script>
    </body>
</html>
