@extends('frontend.layouts.master')

@section('title', '404 - Page Not Found')

@section('meta_description', 'The page you are looking for could not be found.')

@section('content')

    <section class="py-5">
        <div class="container text-center">

            <h1 class="display-1 fw-bold text-primary">
                404
            </h1>

            <h2 class="mb-3">
                Oops! Page Not Found
            </h2>

            <p class="text-muted mb-4">
                The page you are looking for doesn't exist or has been moved.
            </p>

            <a href="{{ route('frontend.home') }}" class="btn btn-primary px-4">
                Back To Home
            </a>

        </div>
    </section>

@endsection
