<div class="row mt-3">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <h5 class="card-title">{{$title}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$subTitle}}</h6>
        </div>
        <ul class="list-group list-group-flush">
            @foreach($items as $item)
                <li class="list-group-item">
                    @if( $hasLink === 'true')
                    <a href="{{ route('posts.show',['post' =>$item->id]) }}">
                        {{ $item->$show }}
                    </a>
                    @else
                            {{ $item->$show }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
