@extends('layout')
@section('content')
    <form action="{{ route('users.update',['user' =>$user->id]) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : ''}}" class="img-thumbnail">
                <div class="card mt-4">
                    <div class="card-body">
                        <h6>upload different photo</h6>
                        <input type="file" class="form-control-file" name="avatar">
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="form-group">
                    <label for="name">Name: </label>
                    <input type="text" class="form-control" name="name" value="{{ old('avatar') ?? $user->name }}">
                </div>
                <x-errors/>
                <div class="form-group">
                    <input type="submit" value="Save Changes" class="btn btn-primary" >
                </div>
            </div>
        </div>
    </form>
@endsection
