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

                        Tags

                    </label>

                    <select name="tags[]" class="form-select tag-select" multiple>

                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>

                                {{ $tag->name }}

                            </option>
                        @endforeach

                    </select>

                    @error('tags')
                        <small class="text-danger">

                            {{ $message }}

                        </small>
                    @enderror

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

                        Select From Media Library

                    </label>

                    <select name="media_id" class="form-select">

                        <option value="">

                            Select Image

                        </option>

                        @foreach ($media as $item)
                            <option value="{{ $item->id }}">

                                {{ $item->file_name }}

                            </option>
                        @endforeach

                    </select>

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
@push('scripts')
    <script>
        $(function() {

            $('#content').summernote({

                height: 500,

                callbacks: {

                    onImageUpload: function(files) {

                        uploadImage(files[0]);

                    }

                }

            });

            function uploadImage(file) {

                let data = new FormData();

                data.append('file', file);

                data.append('_token', '{{ csrf_token() }}');

                $.ajax({

                    url: "{{ route('admin.summernote.upload') }}",

                    method: "POST",

                    data: data,

                    processData: false,

                    contentType: false,

                    success: function(res) {

                        $('#content').summernote('insertImage', res.location);

                    },

                    error: function(err) {

                        console.log(err);

                        alert('Image upload failed.');

                    }

                });

            }

        });
    </script>

    <script>
        $('.tag-select').select2({
            placeholder: "Select Tags"
        });
    </script>
@endpush
