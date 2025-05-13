@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h1 class="text-center mt-5">Welcome to the Forum</h1>
        </div>

        <div class="row">
            <div class="col-md-12 position-relative">
                <div class="text-end m-3">
                    <span class="category">{{ $discussion->category->name }}</span> |
                    <span class="user">{{ $discussion->user->name }}</span>
                </div>

                <img src="{{ $discussion->picture ? asset($discussion->picture) : asset('images/placeholder.jpg') }}"
                    alt="Image" class="img-fluid mb-3 d-block mx-auto">

                <h2 class="text-start">{{ $discussion->title }}</h2>
                <p class="text-start">{{ $discussion->description }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="col-md-12 my-3">
                    <a href="{{ route('comments.create', $discussion->id) }}" class="btn btn-secondary btn-block">Add new comment</a>
                </div>
                
                
                

                @if ($comments->isEmpty())
                    <div class="alert alert-info text-center" role="alert">
                        No comments yet!
                    </div>
                @else
                @endif
                @foreach ($comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $comment->user->name }}</h5>
                        <p class="card-text">{{ $comment->content }}</p>
                
                        <!-- Display the created_at timestamp -->
                        <p class="text-muted">Posted on {{ $comment->created_at->format('F j, Y, g:i a') }}</p> <!-- You can format this date as you like -->
                
                        @if(auth()->check() && (auth()->user()->id === $comment->user_id || auth()->user()->role_id === 1))  <!-- Check if user is the owner or admin -->
                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            
                            <!-- Add delete button with confirmation -->
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                            </form>
                        @endif
                    </div>
  
                </div>
                
                @endforeach

            </div>
        </div>
    </div>
@endsection
