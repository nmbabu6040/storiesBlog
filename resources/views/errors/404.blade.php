@extends('frontend.layouts.master')

@section('title', 'Page Not Found')

@section('content')

    <div class="container py-5 text-center">

        <h1>404</h1>

        <h3>Page Not Found</h3>

        <a href="{{ route('frontend.home') }}" class="btn btn-primary mt-3">

            Back Home

        </a>

    </div>

@endsection
