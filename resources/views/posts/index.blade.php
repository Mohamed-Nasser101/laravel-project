@extends("layout")
@section("content")
    <div class="row">
        <div class="col-8">
    @forelse ($posts as $post)
        <div>

            <h2>
                @if($post->trashed())
                    <del>
                @endif
                <a href="{{ route('posts.show',['post' => $post->id ]) }}" class="{{ $post->trashed() ? 'text-muted' : '' }}">{{$post->title}}</a>
                @if($post->trashed())
                    </del>
                @endif
            </h2>

            <x-updated type="added" name="{{ $post->user->name }}" time="{{  $post->created_at }}" :user-id="$post->user->id" />

            <x-tags :tags="$post->tags" />

            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>no comments</p>
            @endif
            @auth
            @can('update',$post)
            <a href="{{ route('posts.edit' ,['post' => $post->id]) }}" class="btn btn-primary btn-sm">edit</a>
            @if(!$post->trashed())
                @can('delete',$post)
            <a href="" class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('del').submit()">delete</a>
                    <form action="{{ route('posts.destroy' , $post->id ) }}" method="post" class="col" id="del"> @csrf @method('DELETE') </form>
                @endcan
            @endif

            {{--@if($post->trashed())
                @can('restore',$post)
                    <a href="" class="btn btn-info btn-sm" onclick="event.preventDefault();document.getElementById('store').submit()">restore</a>
                    <form action="{{ route('posts.restore' , $post->id ) }}" method="post" class="col" id="store"> @csrf </form>
                @endcan
            @endif--}}
            @endcan
            @endauth
        </div>

    @empty
        <p>No posts yet</p>
    @endforelse
        </div>
        <div class="col-4">
            <div class="container">
                <x-card title="Most Commented" subTitle="What  people are talking abou" :items="$mostCommented" hasLink="true" show="title" />
                <x-card title="Most Active Users" subTitle="Who is talking too much" :items="$mostActive" hasLink="false" show="name" />
                <x-card title="Most Active Users last month" subTitle="Who is talking too much in the last month"
                        :items="$mostActiveLastMonth" hasLink="false" show="name" />
            </div>
        </div>
    </div>
@endsection
