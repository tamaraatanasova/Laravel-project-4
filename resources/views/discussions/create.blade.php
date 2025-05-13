@extends('layouts.main')


@section('content')
<div class="container mt-5">
    <form action="{{ route('discussions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group my-2 mt-5">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group my-2">
            <label for="picture">Picture </label>
            <input type="file" class="form-control-file" name="picture" id="picture">
        </div>

        <div class="form-group my-2">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group my-2">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        

        <button type="submit" class="btn btn-success">Create Discussion</button>
    </form>
</div>
@endsection
