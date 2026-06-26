@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Total Posts</h6>

                    <h2>{{ $totalPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Categories</h6>

                    <h2>{{ $totalCategories }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Featured Posts</h6>

                    <h2>{{ $featuredPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Messages</h6>

                    <h2>{{ $totalMessages }}</h2>

                </div>

            </div>

        </div>

    </div>

@endsection
