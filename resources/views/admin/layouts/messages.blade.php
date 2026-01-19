<!-- Error Messages -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Whoops! Something went wrong:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Flash Messages -->
@foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning', 'info' => 'info'] as $msg => $type)
    @if (session($msg))
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            {{ session($msg) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach


{{-- <div>
    @if ($errors->any())
        <ul class="alert">
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @foreach (['success' => 'success', 'error' => 'danger'] as $msg => $type)
        @if (session($msg))
            <div class="alert alert-{{ $type }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach
</div> --}}


{{-- <div>
    @if ($errors->any())
        <ul class="alert">
            @foreach ($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @foreach (['success', 'error'] as $msg)
        @if (session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach
</div> --}}
