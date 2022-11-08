@if (session('warning'))
    <div class="card-body">
        @foreach(session('warning') as $warning)
        <div class="alert alert-danger" role="alert">
            {{$warning}}
        </div>
    @endforeach
@endif

            @if (session('success'))
                <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
@endif
