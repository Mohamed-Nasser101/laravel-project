@if ($errors->any())
    <div class="mb-2 mt-2">
        @foreach ($errors->all() as $err)
            <div class="alert alert-danger " role="alert">
                {{ $err }}
            </div>
        @endforeach
    </div>
@endif
