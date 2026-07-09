@extends('admin.layouts.master')

@section('title', 'Edit Advertisement')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4>Edit Advertisement</h4>

        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-secondary">

            Back

        </a>

    </div>

    <form action="{{ route('admin.advertisements.update', $advertisement) }}" method="POST" enctype="multipart/form-data">

        @csrf

        @method('PUT')

        @include('admin.advertisement._form')

        <button class="btn btn-primary mt-3">

            Update Advertisement

        </button>

    </form>

@endsection
