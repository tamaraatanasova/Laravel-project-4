<div class="container mt-4">
    @foreach ($discussions as $discussion)
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-3 text-center p-2">
                    <img src="{{ $discussion->picture ? asset($discussion->picture) : asset('images/placeholder.jpg') }}"
                        class="img-fluid rounded" alt="Discussion Image" style="max-height: 150px;">
                </div>
                <div class="col-md-9">
                    <div class="card-body d-flex justify-content-between flex-wrap">
                        <div class="flex-grow-1 pe-3">
                            <h5 class="card-title mb-2">
                                <a href="/discussions/{{ $discussion->id }}" class="text-decoration-none text-dark">
                                    {{ $discussion->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-0">{{ $discussion->description }}</p>
                        </div>

                        <div class="d-flex align-items-center text-end"
                            style="min-width: 300px; justify-content: flex-end;">


                            @auth
                            @if (auth()->user()->role == 1 )
                                @if ($discussion->is_approved)
                                    <form action="{{ route('discussions.unapprove', $discussion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success me-1"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('discussions.approve', $discussion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger me-1"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                @endif
                        
                                <a href="{{ route('discussions.edit', $discussion->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            @endif
                        @endauth
                        

                            <div class="me-3 text-end" style="width: 140px;">
                                <span class="text-muted">{{ $discussion->category->name }}</span> |
                                <small class="text-muted">{{ $discussion->user->name }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
