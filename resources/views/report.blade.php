<h1>Отчет на {{ date('Y-m-d') }}</h1>
<ul>
    <li>Свободно: {{ $summary->free }}</li>
    <li>Продано: {{ $summary->sold }}</li>
    <li>Забронировано: {{ $summary->booked }}</li>
    <li>Сломано?: {{ $summary->broken }}</li>
</ul>

@if(count($apartments))
    <h2>Изменения</h2>
@endif
@foreach ($apartments as $apt)
    @if(count($apt->diff))
        <b>Квартира №{{ $apt->door }} на {{ $apt->floor }} этаже:</b>
        <ul>
            @foreach($apt->diff as $field => $value)
                <li>{{ $field }} теперь {{ $value }}</li>
            @endforeach
        </ul>
    @endif
@endforeach