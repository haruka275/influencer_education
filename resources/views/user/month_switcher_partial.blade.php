{{-- resources/views/user/month_switcher_partial.blade.php --}}
<div class="curriculum_list-month">
    <div class="back-btn-curriculum_list">
        <a href="/">←戻る</a>
    </div>
    <div class="month" id="month-switcher">
        @php
            // gradeIdに応じて色グループを判定（getColorClass関数使うなら不要）
            $gradeId = $selectedGrade->id ?? 1;
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
        @endphp

        <a href="#" class="month-nav" data-month="{{ $prevMonth }}">◀</a>
        <h4 style="margin: 0;">
            {{ $displayMonth->format('Y年m月') }}スケジュール 
        </h4>
        <a href="#" class="month-nav" data-month="{{ $nextMonth }}">▶</a>
        <span id="current-grade" class="select-grade {{ $selectedColorClass }}">
            {{ $selectedGrade->name ?? '未選択' }}
        </span>
    </div>
</div>
