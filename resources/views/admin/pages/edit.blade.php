@extends('admin.layouts.master')

@section('title', 'Edit Page')

@section('content')

    <h4 class="mb-4">

        Edit Page

    </h4>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('admin.pages._form')

        <button class="btn btn-primary">
            Update
        </button>

    </form>

@endsection
@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => console.error(error));
    </script>

    <script>
        const title = document.getElementById('title');
        const slug = document.getElementById('slug');

        title.addEventListener('keyup', function() {

            slug.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-');

        });
    </script>
@endpush
