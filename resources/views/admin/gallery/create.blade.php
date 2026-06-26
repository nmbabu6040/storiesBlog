@extends('admin.layouts.master')

@section('title', 'Add Gallery')

@section('content')

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="card">

            <div class="card-body">

                <input type="file" name="image" class="form-control">

                <button class="btn btn-primary mt-3">

                    Upload

                </button>

            </div>

        </div>

    </form>

@endsection
