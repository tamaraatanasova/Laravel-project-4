@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-9 mt-3">

            <form action="{{ route('comments.store', $discussion->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea class="form-control my-3" id="content" name="content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
</div>


@endsection

   