@extends('admin.layouts.master')

@section('title', 'Edit Tag')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Edit Tag</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.tags.update', $tag) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">

                        Tag Name

                    </label>

                    <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control">

                    @error('name')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

                </div>

                <div class="form-check mb-3">

                    <input class="form-check-input" type="checkbox" name="status" value="1"
                        {{ $tag->status ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Active

                    </label>

                </div>

                <button class="btn btn-primary">

                    Update

                </button>

                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">

                    Back

                </a>

            </form>

        </div>

    </div>

@endsection
