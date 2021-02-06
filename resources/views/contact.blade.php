@extends("layout")
@section("content")
<h1>hello from contact</h1>
    @can('home.secret')
        <p>
            you are admin go to <a href="{{ route('secret') }}">secret</a>
        </p>
    @endcan
@endsection
