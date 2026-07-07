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

                    <h6>Featured Posts</h6>

                    <h2>{{ $featuredPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Published Posts</h6>

                    <h2>{{ $publishedPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Pending Posts</h6>

                    <h2>{{ $pendingPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Total Users</h6>

                    <h2>{{ $totalUsers }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Total Comments</h6>

                    <h2>{{ $totalComments }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h6>Total Subscribers</h6>

                    <h2>{{ $totalSubscribers }}</h2>

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

                    <h6>Messages</h6>

                    <h2>{{ $totalMessages }}</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>Latest Posts</strong>

                </div>

                <div class="card-body p-0">

                    <table class="table table-striped mb-0">

                        <thead>

                            <tr>

                                <th>Title</th>

                                <th>Category</th>

                                <th>Author</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($latestPosts as $post)
                                <tr>

                                    <td>{{ Str::limit($post->title, 40) }}</td>

                                    <td>{{ $post->category?->name }}</td>

                                    <td>{{ $post->user?->name }}</td>

                                    <td>

                                        @if ($post->review_status == 'approved')
                                            <span class="badge bg-success">

                                                Approved

                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">

                                                Pending

                                            </span>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>Latest Users</strong>

                </div>

                <ul class="list-group list-group-flush">

                    @foreach ($latestUsers as $user)
                        <li class="list-group-item">

                            {{ $user->name }}

                        </li>
                    @endforeach

                </ul>

            </div>

        </div>

    </div>

    <div class="card shadow-sm mt-4">

        <div class="card-header">

            <strong>Posts (Last 7 Days)</strong>

        </div>

        <div class="card-body">

            <canvas id="postsChart"></canvas>

        </div>

    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            console.log('Chart Script Loaded');

            const canvas = document.getElementById('postsChart');

            console.log(canvas);

            if (canvas) {

                new Chart(canvas, {

                    type: 'line',

                    data: {

                        labels: ['6', '5', '4', '3', '2', '1', 'Today'],

                        datasets: [{

                            label: 'Posts',

                            data: @json($postsChart),

                            borderColor: 'blue',

                            borderWidth: 2

                        }]

                    }

                });

            }

        });
    </script>
@endpush
