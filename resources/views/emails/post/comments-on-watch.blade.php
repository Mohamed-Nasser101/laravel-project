@component('mail::message')
# Comment was posted on your post your are watching.

Hi: {{$user->name }}

@component('mail::button', ['url' =>  route('posts.show',['post' => $comment->commentable->id])  ])
    {{ $comment->commentable->title }}
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
    visit  {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
    {{ $comment->content }}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
