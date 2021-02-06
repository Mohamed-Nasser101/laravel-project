<style>
    body{
        font-family: Arial ,Helvetica ,sans-serif ;
    }
</style>

<p>Hi: {{ $comment->user->name }}</p>
<p>
    someone posted on on your post
    <a href="{{ route('posts.show',['post' => $comment->commentable->id]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>
<hr>
<p>
{{--    <img src="{{ $message->embed($comment->user->image->url()) }}" alt="">--}}
    <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">
        {{ $comment->user->name }}
    </a> said
</p>
<p>
    {{ $comment->content }}
</p>
