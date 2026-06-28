@extends('admin.layouts.master')

@section('title', 'Create Page')

@section('content')

    <h4 class="mb-4">

        Create Page

    </h4>

    <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        @include('admin.pages._form')

        <button class="btn btn-primary">
            Save
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
