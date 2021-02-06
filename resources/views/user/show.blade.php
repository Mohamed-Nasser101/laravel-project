@extends('layout')
@section('content')
        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : ''}}" class="img-thumbnail avatar">
            </div>
            <div class="col-8">
                <h3>{{ $user->name }}</h3>
                @can('update',$user)
                <a href="{{route('users.edit',['user' => $user->id])}}" class="btn btn-primary">Edit</a>
                @endcan
                <p class="text-muted">Currently view by {{ $counter }} users</p>
                <x-form route="{{ route('users.comment.store' ,['user' => $user->id]) }}" />
                <x-comments :comments="$user->commentsOn"/>

            </div>
        </div>
@endsection

