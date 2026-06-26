@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Edit Category</h4>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Category Image
                    </label>

                    <input type="file" name="image" class="form-control">

                    @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" width="120" class="mt-2">
                    @endif

                </div>

                <div class="mb-3">

                    <label>Name</label>

                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">

                    @error('name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="form-check mb-3">

                    <input class="form-check-input" type="checkbox" name="status" value="1"
                        {{ $category->status ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Active

                    </label>

                </div>

                <button type="submit" class="btn btn-primary">

                    Update Category

                </button>

            </form>

        </div>

    </div>

@endsection
