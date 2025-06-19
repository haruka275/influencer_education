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

                {{-- 配信日時リンク表示 --}}{{-- 配信期間だけ繰り返し --}}
                
                {{-- 常時公開 or 配信期間 --}}
                @if($curriculum->alway_delivery_flg)
                    <div class="delivery-label">
                        <a href="{{ route('user.show.delivery', ['id' => $curriculum->id]) }}">
                            常時公開
                        </a>
                    </div>
                @elseif($curriculum->deliveryTime->isNotEmpty())
                    <ul class="delivery-list">
                        @foreach($curriculum->deliveryTime as $delivery)
                            @php
                                $from = \Carbon\Carbon::parse($delivery->delivery_from);
                                $to = \Carbon\Carbon::parse($delivery->delivery_to);
                            @endphp

                            @while($from->lt($to))
                                @php
                                    $dayStart = $from->copy()->startOfDay();
                                    $dayEnd = $from->copy()->endOfDay();
                                    $startTime = $from->greaterThan($dayStart) ? $from : $dayStart;
                                    $endTime = $to->lessThan($dayEnd) ? $to : $dayEnd;
                                @endphp

                                <li>
                                    <a href="{{ route('user.show.delivery', ['id' => $curriculum->id]) }}">
                                        {{ $startTime->format('n月j日 H:i') }} ～ {{ $endTime->format('H:i') }}
                                    </a>
                                </li>

                                @php
                                    $from = $from->copy()->addDay()->startOfDay();
                                @endphp
                            @endwhile
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
@endif