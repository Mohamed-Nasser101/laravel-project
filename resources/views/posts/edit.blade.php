@extends('layout')
@section('content')
    <form action="{{ route('posts.update'  , ['post' => $post->id ]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('Put')

        <div class="form-group">
        <label for="">Title</label>
        <input type="text" name="title" value="{{ old('title' , $post->title ) }}" class="form-control">
        </div>
        <div class="form-group">
        <label for="">content</label>
        <textarea name="content" id="" cols="30" rows="10" class="form-control">{{ old('content' , $post->content ) }}</textarea>
        </div>

        <div class="form-group">
            <label for="">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control-file">
        </div>

        <x-errors/>
        <input type="submit" value="Update" class="btn btn-primary btn-block">

    </form>
@endsection
