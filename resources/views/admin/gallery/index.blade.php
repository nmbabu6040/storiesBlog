@extends('admin.layouts.master')

@section('title', 'Gallery')

@section('content')

    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary mb-3">

        Add Image

    </a>

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
