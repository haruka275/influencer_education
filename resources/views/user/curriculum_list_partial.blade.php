{{-- 授業一覧（$curriculums）」を表示する部分 --}}

@if($curriculums->isEmpty()) {{-- $curriculumsが空（授業が1件もない）か --}}
    <p>該当する授業はありません。</p>
@else
    <div class="curriculum-container">
        @foreach($curriculums as $curriculum)
            <div class="curriculum-item">
                <img src="{{ asset($curriculum->thumbnail) }}" alt="サムネイル">

                <h5>{{-- 授業タイトルリンク表示 --}}
                    <a href="{{ route('user.show.delivery', ['id' => $curriculum->id]) }}">
                        {{ $curriculum->title }}
                    </a>
                </h5>
                @include('user.partials.delivery_times', ['curriculum' => $curriculum])
            </div>
        @endforeach
    </div>
@endif