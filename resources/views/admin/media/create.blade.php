@extends('admin.layouts.master')

@section('title', 'Upload Image')

@section('content')

    <div class="card">

        <div class="card-body">

            <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label>Select Image</label>

                    <input type="file" name="image" class="form-control">

                </div>

                <button class="btn btn-success">

                    Upload

                </button>

            </form>

        </div>

    </div>

@endsection
