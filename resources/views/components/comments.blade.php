@forelse($comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    <x-tags :tags="$comment->tags" />
    <p class="text-muted">
        {{--                add {{ $comment->created_at->diffForHumans() }}--}}
        <x-updated type="added" name="{{ $comment->user->name }}" time="{{  $comment->created_at }}" :userId="$comment->user_id"/>
    </p>
@empty
    <p>No comments</p>
@endforelse
