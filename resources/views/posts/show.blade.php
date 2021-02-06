@extends("layout")
@section("content")
    <div class="row">
        <div class="col-8">
    @if ($post)
        <div class="row">
        <h2 class="col">
            {{ $post->title }}
{{--                <x-badge say="New" show="{{ now()->diffInMinutes($post->created_at) < 100 }}"/>  --}}{{--show it if it less than 30 minutes--}}
        </h2>

        </div>

                <img src="{{ $post->image ? $post->image->url() : '' }}">

        <p>{{ $post->content }}</p>
{{--        <p>created since {{ $post->created_at->diffForHumans() }} </p>--}}
        <x-updated type="created since " time="{{ $post->created_at }}" name="{{ $post->user->name }}" :userId="$post->user->id"/>
        <x-tags :tags="$post->tags" />

        <p class="text-muted">{{ $viewers }} people on the page</p>
        <h4>Comments</h4>
            <x-form route="{{ route('posts.comments.store' ,['post' => $post->id]) }}" />

        <x-comments :comments="$post->comments"/>

    @else
        <p>no posts to show</p>
    @endif
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
