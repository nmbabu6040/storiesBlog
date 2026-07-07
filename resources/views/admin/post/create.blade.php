@extends('admin.layouts.master')

@section('title', 'Create Post')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Create Post</h4>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select name="category_id" class="form-select">

                        <option value="">
                            Select Category
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Title
                    </label>

                    <input type="text" name="title" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Thumbnail
                    </label>

                    <input type="file" name="thumbnail" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Content
                    </label>

                    <textarea id="content" name="content" rows="10" class="form-control">{{ old('content') }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Meta Title
                    </label>

                    <input type="text" name="meta_title" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Meta Description
                    </label>

                    <textarea name="meta_description" rows="3" class="form-control"></textarea>

                </div>

                <div class="form-check mb-2">

                    <input class="form-check-input" type="checkbox" name="featured" value="1">

                    <label class="form-check-label">

                        Featured Post

                    </label>

                </div>

                @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Editor']))
                    <div class="form-check mb-3">

                        <input class="form-check-input" type="checkbox" name="status" value="1" checked>

                        <label class="form-check-label">

                            Publish

                        </label>

                    </div>
                @else
                    <div class="alert alert-warning">

                        Your post will be submitted for review before publishing.

                    </div>
                @endif

                <button type="submit" class="btn btn-primary">

                    Save Post

                </button>

            </form>

        </div>

    </div>

@endsection
{{-- @push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'), {

                simpleUpload: {

                    uploadUrl: "{{ route('admin.ckeditor.upload') }}",

                    headers: {

                        'X-CSRF-TOKEN': '{{ csrf_token() }}'

                    }

                }

            })
            .catch(error => console.error(error));
    </script>
@endpush --}}
@push('scripts')
    <script>
        window.addEventListener('load', function() {

            const textarea = document.getElementById('content');

            console.log(textarea);

            if (textarea) {

                CKEDITOR.replace(textarea, {
                    height: 500
                });

            }

        });
    </script>
@endpush
