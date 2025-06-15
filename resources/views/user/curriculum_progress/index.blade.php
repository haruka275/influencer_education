@extends('layouts.app')

@section('content')
<style>
    .header-area {
        background-color: red;
        padding: 10px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .nav-buttons a {
        background-color: skyblue;
        color: white;
        padding: 8px 16px;
        margin-right: 10px;
        border-radius: 5px;
        text-decoration: none;
    }
    .logout-text {
        color: black;
        text-decoration: none;
    }
    .main-area {
        background-color: white;
        padding: 20px;
    }
    .grade-button {
        color: white;
        padding: 8px 16px;
        margin: 5px;
        border-radius: 5px;
        border: none;
    }
    .grade-primary { background-color: #87CEFA; }
    .grade-secondary { background-color: #4682B4; }
    .grade-high { background-color: #90EE90; }
    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    .user-info img {
        border-radius: 50%;
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
    .grades-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 40px;
        margin-top: 40px;
    }
    .grade-section {
        display: flex;
        flex-direction: column;
    }
    .grade-section .grade-button {
        margin-bottom: 10px;
        width: fit-content;
    }
    .curriculum-item {
        margin: 4px 0;
        display: flex;
        align-items: center;
    }
    .curriculum-item img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
        object-fit: cover;
    }
    .curriculum-title {
        margin-right: 10px;
    }
    .curriculum-title.disabled {
        color: grey;
    }
    .completed-badge {
        color: green;
        font-size: 12px;
    }
</style>

<div class="header-area">
    <div class="nav-buttons">
        <a href="#">時間割り</a>
        <a href="#">授業進捗</a>
        <a href="#">プロフィール設定</a>
    </div>
    <a href="{{ route('logout') }}" class="logout-text"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<div class="main-area">
    <a href="javascript:history.back()" style="color: black; text-decoration: none;">← 戻る</a>

    <div class="user-info">
        <img src="{{ $user->profile_image_url ?? asset('default-user.png') }}" alt="ユーザー画像">
        <div>
            <h2>{{ $user->name }}の授業進捗</h2>
            <p>現在の学年：
                <button class="grade-button {{ config('grades.grade_classes')[$user->grade->name] ?? 'grade-primary' }}">
                    {{ $user->grade->name }}
                </button>
            </p>
        </div>
    </div>

    @php
        $gradeClasses = config('grades.grade_classes'); // configから取得
        $gradeChunks = array_chunk($gradeClasses, 3, true);
    @endphp

    @foreach ($gradeChunks as $gradeRow)
        <div class="grades-grid">
            @foreach ($gradeRow as $gradeName => $gradeClass)
                <div class="grade-section">
                    <button class="grade-button {{ $gradeClass }}">{{ $gradeName }}</button>
                    <div>
                        @php $itemCount = 0; @endphp
                        @if (isset($curriculums_by_grade[$gradeName]))
                            @foreach ($curriculums_by_grade[$gradeName] as $curriculum)
                                @php
                                    $itemCount++;
                                    $canAccess = $curriculum->grade_id <= $user->grade_id;
                                    $cleanTitle = $curriculum->title; // Blade内で生成しない
                                    $progress = $curriculum->progress;
                                @endphp
                                <div class="curriculum-item">
                                    <img src="{{ asset('storage/' . $curriculum->thumbnail) }}" alt="サムネイル">

                                    @if ($canAccess)
                                        <a href="#" class="curriculum-title">{{ $cleanTitle }}</a>
                                    @else
                                        <span class="curriculum-title disabled">{{ $cleanTitle }}</span>
                                    @endif

                                    @if ($progress && $progress->clear_flg)
                                        <span class="completed-badge">受講済み</span>
                                    @endif
                                </div>
                            @endforeach

                            @for ($i = $itemCount + 1; $i <= 5; $i++)
                                <div class="curriculum-item">
                                    <img src="{{ asset('default-thumbnail.png') }}" alt="サムネイル">
                                    <span class="curriculum-title">授業タイトル{{ $i }}</span>
                                </div>
                            @endfor
                        @else
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="curriculum-item">
                                    <img src="{{ asset('default-thumbnail.png') }}" alt="サムネイル">
                                    <span class="curriculum-title">授業タイトル{{ $i }}</span>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
