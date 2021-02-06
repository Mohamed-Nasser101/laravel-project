@component('mail::message')
# Comment was posted on your post

Hi: {{ $comment->user->name }}

someone posted on on your post

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
