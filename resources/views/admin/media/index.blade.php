@extends('admin.layouts.master')

@section('title', 'Media Library')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>Media Library</h3>

        <a href="{{ route('admin.media.create') }}" class="btn btn-primary">

            Upload Image

        </a>

    </div>

    <div class="row">

        @foreach ($media as $item)
            <div class="col-md-3 mb-4">

                <div class="card">

                    <img src="{{ asset('storage/' . $item->file_path) }}" class="card-img-top"
                        style="height:180px;object-fit:cover;">

                    <div class="card-body text-center">

                        <small>{{ $item->file_name }}</small>

                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="mt-2">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm w-100">

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            </div>
        @endforeach

    </div>

    {{ $media->links() }}

@endsection
