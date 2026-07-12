@extends('admin.layouts.master')

@section('title', 'Gallery')

@section('content')

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary mb-3">

            Add Image

        </a>

        <a href="{{ route('admin.galleries.trash') }}" class="btn btn-warning">

            Trash

        </a>
    </div>



    <div class="row">

        @foreach ($galleries as $gallery)
            <div class="col-md-3 mb-4">

                <div class="card">

                    <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top">

                    <div class="card-body">

                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

            </div>
        @endforeach

    </div>

@endsection
