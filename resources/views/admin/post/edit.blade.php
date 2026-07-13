@extends('admin.layouts.master')

@section('title', 'Create Post')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Edit Post</h4>

        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <select name="category_id" class="form-select">

                        <option value="">
                            Select Category
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
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
                            <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>

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

                    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Thumbnail
                    </label>

                    @if ($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" width="80">
                    @endif

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
                            <option value="{{ $item->id }}" {{ $post->media_id == $item->id ? 'selected' : '' }}>

                                {{ $item->file_name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Content
                    </label>

                    <textarea id="content" name="content" rows="10" class="form-control">{{ old('content', $post->content) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Meta Title
                    </label>

                    <input type="text" name="meta_title" class="form-control"
                        value="{{ old('meta_title', $post->meta_title) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Meta Description
                    </label>

                    <textarea name="meta_description" rows="3" class="form-control">
                        {{ old('meta_description', $post->meta_description) }}
                    </textarea>

                </div>

                <div class="form-check mb-2">

                    <input class="form-check-input" type="checkbox" name="featured" value="1"
                        {{ $post->featured ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Featured Post

                    </label>

                </div>

                <div class="form-check mb-4">

                    <input class="form-check-input" type="checkbox" name="status" value="1"
                        {{ $post->status ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Publish

                    </label>

                </div>

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
