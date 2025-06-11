
<!-- 表示イメージに合わせてBladeファイル全体修正版 -->

<!-- resources/views/user/progress/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-xl font-bold mb-4">現在の学年： 小学校1年生 年生</h2>

    <!-- 学年ごとの授業ブロック -->
    @php
        $grades = [
            '小学校1年生', '小学校2年生', '小学校3年生',
            '小学校4年生', '小学校5年生', '小学校6年生',
            '中学校1年生', '中学校2年生', '中学校3年生',
            '高校1年生', '高校2年生', '高校3年生'
        ];
    @endphp

    @foreach (array_chunk($grades, 3) as $gradeGroup)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            @foreach ($gradeGroup as $grade)
                <div class="bg-white rounded-lg shadow p-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded mb-4 w-full">
                        {{ $grade }}（ボタン）
                    </button>
                    <ul class="list-disc pl-5">
                        @for ($i = 1; $i <= 5; $i++)
                            <li>授業タイトル{{ $i }}</li>
                        @endfor
                    </ul>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
