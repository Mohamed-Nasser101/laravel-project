<p class="text-muted">
    {{$type ? $type : 'added' }} {{ Illuminate\Support\Carbon::parse($time)->diffForHumans() }}
    @if(isset($userId))
        {{ 'by '}}<a href="{{ route('users.show',['user' => $userId]) }}">{{$name}}</a>
    @else
    {{ 'by '.$name }}
    @endif
</p>
