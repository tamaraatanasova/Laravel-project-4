@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h1 class="text-center mt-5">Welcome to the Forum</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('discussions.create') }}" class="btn btn-secondary btn-block">Add new discussion</a>
            </div>
            @auth
                @if (auth()->user()->role == 1)
                    <div class="col-md-12 mt-3">
                        <form action="{{ route('discussions.approveAll') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block">Approve All Discussions</button>
                        </form>
                    </div>
                @endif
            @endauth


        </div>

        @if ($discussions->isEmpty())
            <div class="row">
                <h5 class="text-center mt-5 text-secondary">Nothing here yet! Start a topic</h5>
            </div>
        @endif

        <div class="row">
            @include('partials.discussion')
        </div>
    </div>
@endsection
