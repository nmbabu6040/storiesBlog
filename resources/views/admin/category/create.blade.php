@extends('admin.layouts.master')

@section('title', 'Create Category')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Create Category</h4>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label>Name</label>

                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">

                    @error('name')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Category Image
                    </label>

                    <input type="file" name="image" class="form-control">

                </div>


                <div class="form-check mb-3">

                    <input class="form-check-input" type="checkbox" name="status" value="1" checked>

                    <label class="form-check-label">
                        Active
                    </label>

                </div>

                <button class="btn btn-primary">

                    Save Category

                </button>

            </form>

        </div>

    </div>

@endsection
