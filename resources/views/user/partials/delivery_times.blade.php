{{-- 配信日時の表示 --}}
{{-- 常時公開 or 配信期間 --}}

@if($curriculum->alway_delivery_flg)
    <div class="delivery-label">
        <a href="{{ route('user.show.delivery', ['id' => $curriculum->id]) }}">常時公開</a>
    </div>
@elseif(!empty($curriculum->formattedDeliveries))
    <ul class="delivery-list">
@foreach($curriculum->formattedDeliveries as $delivery)
    <li class="{{ $loop->index >= 4 ? 'hidden-extra' : '' }}">
        <a href="{{ route('user.show.delivery', ['id' => $curriculum->id]) }}">
            {{ $delivery['start']->format('n月j日 H:i') }} ～ {{ $delivery['end']->format('H:i') }}
        </a>
    </li>
@endforeach
    </ul>
    @if(count($curriculum->formattedDeliveries) > 4)
        <button class="show-more-btn" onclick="toggleDeliveries(this)">もっと見る</button>
    @endif
@endif
<script>
    function toggleDeliveries(button) {
        const list = button.previousElementSibling;
        if (list) {
            list.querySelectorAll('.hidden-extra').forEach(el => el.style.display = 'list-item');
        }
        button.style.display = 'none';
    }
</script>
