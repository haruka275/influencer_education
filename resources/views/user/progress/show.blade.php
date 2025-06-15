@extends('layouts.app')

@section('content')
    <!-- 赤背景ヘッダー -->
    <div class="bg-red-500 p-4 flex justify-between items-center text-white">
        <div class="space-x-4">
            <a href="{{ route('user.schedule') }}" class="bg-sky-400 px-4 py-2 rounded text-white">時間割り</a>
            <a href="{{ route('user.progress') }}" class="bg-sky-400 px-4 py-2 rounded text-white">授業進捗</a>
            <a href="{{ route('user.profile') }}" class="bg-sky-400 px-4 py-2 rounded text-white">プロフィール設定</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-black">ログアウト</button>
        </form>
    </div>

    <!-- 白背景エリア -->
    <div class="bg-white p-6">
        <a href="{{ url()->previous() }}" class="text-blue-500 underline">← 戻る</a>

        <!-- ユーザー名・学年 -->
        <div class="my-4 flex items-center space-x-4">
            <img src="{{ asset('storage/' . ($user->profile_img ?? 'default.png')) }}" alt="プロフィール画像" class="w-12 h-12 rounded-full">
            <div class="text-xl font-semibold">{{ $user->name }}の授業進捗</div>
        </div>
        <div class="mb-6">
            現在の学年：
            <button class="bg-sky-300 text-white px-3 py-1 rounded">
                {{ $currentGradeName }}
            </button>
        </div>

        <!-- 学年別授業一覧 -->
        <div class="space-y-8">
            @foreach ($groupedCurriculums as $gradeName => $curriculums)
                <div>
                    <h2 class="text-lg font-bold mb-2">
                        <button class="{{ $gradeLabels[$gradeName] ?? 'bg-gray-300' }} text-white px-4 py-2 rounded">
                            {{ $gradeName }}
                        </button>
                    </h2>
                    <ul class="space-y-1 pl-4">
                        @foreach ($curriculums as $curriculum)
                            @php
                                $canAccess = $curriculum->grade_id <= $user->grade_id;
                                $isCleared = $curriculum->progress->first()?->clear_flg == 1;
                            @endphp
                            <li>
                                @if ($canAccess)
                                    <a href="{{ route('user.curriculum.show', $curriculum->id) }}" class="text-blue-600 hover:underline inline-block">
                                        {{ $curriculum->title }}
                                    </a>
                                @else
                                    <span class="text-gray-400">{{ $curriculum->title }}</span>
                                @endif

                                @if ($isCleared)
                                    <span class="ml-2 text-green-500 text-sm">受講済み</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection
