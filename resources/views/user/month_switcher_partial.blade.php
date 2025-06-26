<div class="curriculum_list-month">
    <div class="back-btn-curriculum_list">
        <a href="/">←戻る</a>
    </div>
    <div class="month" id="month-switcher">
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
