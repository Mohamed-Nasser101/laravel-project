@extends('layout')
@section('content')
    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container">
        <div class="form-group">
        <label for="">Title</label>
        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
        </div>

        <div class="form-group">
        <label for="">content</label>
        <textarea name="content" id="" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control-file">
        </div>

        <x-errors index=""/>

        <input type="submit" value="submit" class="form-control btn btn-primary btn-primary">
        </div>
    </form>
@endsection
