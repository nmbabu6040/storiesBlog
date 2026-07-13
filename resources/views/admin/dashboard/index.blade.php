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

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-dark">
                <div class="card-body text-center text-white">
                    <h4>Total Tags</h4>
                    <h2>{{ $totalTags }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-secondary">
                <div class="card-body text-center text-white">
                    <h4>Pages</h4>
                    <h2>{{ $totalPages }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-primary">
                <div class="card-body text-center text-white">
                    <h4>Menus</h4>
                    <h2>{{ $totalMenus }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-success">
                <div class="card-body text-center text-white">
                    <h4>Media Files</h4>
                    <h2>{{ $totalMedia }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-info">
                <div class="card-body text-center text-white">
                    <h4>Total Views</h4>
                    <h2>{{ number_format($totalViews) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-warning">
                <div class="card-body text-center text-white">
                    <h4>Today's Subscribers</h4>
                    <h2>{{ $todaySubscribers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm bg-danger">
                <div class="card-body text-center text-white">
                    <h4>Today's Messages</h4>
                    <h2>{{ $todayMessages }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card shadow">

                <div class="card-header">

                    <h5 class="mb-0">
                        Monthly Statistics
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="dashboardChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-6">

            <div class="card shadow">

                <div class="card-header">

                    <h5 class="mb-0">

                        Top Viewed Posts

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <thead>

                            <tr>

                                <th>Post</th>

                                <th>Views</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($topPosts as $post)
                                <tr>

                                    <td>{{ Str::limit($post->title, 40) }}</td>

                                    <td>{{ number_format($post->views) }}</td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card shadow">

                <div class="card-header">

                    <h5 class="mb-0">

                        Top Categories

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-sm">

                        <thead>

                            <tr>

                                <th>Category</th>

                                <th>Posts</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($topCategories as $category)
                                <tr>

                                    <td>{{ $category->name }}</td>

                                    <td>{{ $category->posts_count }}</td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-header">

                    Latest Users

                </div>

                <div class="card-body">

                    @foreach ($latestUsers as $user)
                        <div class="border-bottom py-2">

                            <strong>{{ $user->name }}</strong>

                            <br>

                            <small>{{ $user->email }}</small>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-header">

                    Latest Subscribers

                </div>

                <div class="card-body">

                    @foreach ($latestSubscribers as $subscriber)
                        <div class="border-bottom py-2">

                            {{ $subscriber->email }}

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-header">

                    Latest Messages

                </div>

                <div class="card-body">

                    @foreach ($latestMessages as $message)
                        <div class="border-bottom py-2">

                            <strong>{{ $message->name }}</strong>

                            <br>

                            <small>{{ Str::limit($message->subject, 35) }}</small>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('dashboardChart');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: @json($months),

                datasets: [

                    {

                        label: 'Posts',

                        data: @json($postData),

                        borderWidth: 1

                    },

                    {

                        label: 'Users',

                        data: @json($userData),

                        borderWidth: 1

                    },

                    {

                        label: 'Subscribers',

                        data: @json($subscriberData),

                        borderWidth: 1

                    }

                ]

            },

            options: {

                responsive: true,

                scales: {

                    y: {

                        beginAtZero: true

                    }

                }

            }

        });
    </script>
@endpush
