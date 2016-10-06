<h1>Отчет на {{ date('Y-m-d') }}</h1>
<ul>
    <li>Всего свободных квартир: {{ $summary->free }}</li>
    <li>Продано: {{ $summary->sold }}</li>
    <li>Забронировано: {{ $summary->booked }}</li>
    <li>Освободилось: {{ $summary->freed }}</li>
    <li>Перешли в странный статус: {{ $summary->broken }}</li>
</ul>

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