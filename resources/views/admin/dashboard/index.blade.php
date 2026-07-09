@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-primary">

                <div class="card-body text-white fw-bold text-center">

                    <h4>Total Posts</h4>

                    <h2>{{ $totalPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-success">

                <div class="card-body text-center text-white">

                    <h4>Featured Posts</h4>

                    <h2>{{ $featuredPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-secondary">

                <div class="card-body text-center text-white">

                    <h4>Published Posts</h4>

                    <h2>{{ $publishedPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-warning">

                <div class="card-body text-center text-white">

                    <h4>Pending Posts</h4>

                    <h2>{{ $pendingPosts }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-danger">

                <div class="card-body text-center text-white">

                    <h4>Total Users</h4>

                    <h2>{{ $totalUsers }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-info">

                <div class="card-body text-center text-white">

                    <h4>Total Comments</h4>

                    <h2>{{ $totalComments }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-success">

                <div class="card-body text-center text-white">

                    <h4>Total Subscribers</h4>

                    <h2>{{ $totalSubscribers }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-black">

                <div class="card-body text-center text-white">

                    <h4>Categories</h4>

                    <h2>{{ $totalCategories }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card shadow-sm bg-primary">

                <div class="card-body text-center text-white">

                    <h4>Messages</h4>

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
