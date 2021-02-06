<div class="mb-2 mt-2">
    @auth
        <form action="{{ $route }}" method="post">
            @csrf
            <div class="form-group">
                <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <x-errors/>
            <button type="submit" class="btn btn-primary btn-block" >Add Comment</button>
        </form>
    @else
        <a href="{{ route('login') }}">sign in</a> to add a comment
    @endauth
</div>
<hr>
