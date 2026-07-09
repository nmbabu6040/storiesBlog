@extends('admin.layouts.master')

@section('title', 'Create Advertisement')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4>Create Advertisement</h4>

        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        @include('admin.advertisement._form')

        <button class="btn btn-primary mt-3">

            Save Advertisement

        </button>

    </form>

@endsection
