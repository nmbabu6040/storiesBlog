@extends('frontend.layouts.master')

@section('title', $post->meta_title ?: $post->title)

@section('meta_description', $post->meta_description)

@section('meta_keywords', $post->meta_keywords)

@section('content')


    <div class="container py-5">

        <nav class="mb-4">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="{{ route('frontend.home') }}">

                        Home

                    </a>

                </li>

                <li class="breadcrumb-item">

                    <a href="{{ route('frontend.category.show', $post->category->slug) }}">

                        {{ $post->category->name }}

                    </a>

                </li>

                <li class="breadcrumb-item active">

                    {{ Str::limit($post->title, 40) }}

                </li>

            </ol>

        </nav>

        <div class="row">

            <div class="col-lg-8">

                <div class="">

                    <div>
                        {{-- <span class="badge bg-primary mb-3">

                            {{ $post->category->name }}

                        </span> --}}

                        <h1 class="mb-3">

                            {{ $post->title }}

                        </h1>

                        <div class="mb-4 text-muted d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center mb-4">

                                <img src="{{ asset('storage/' . $setting->author_image) }}"
                                    alt="{{ $setting->author_name }}" class="rounded-circle me-3" width="40"
                                    height="40">

                                <div>

                                    <h6 class="mb-1">

                                        {{ $setting->author_name }}

                                    </h6>

                                    <small class="text-muted">

                                        {{ $post->created_at->format('d M Y') }}

                                        |

                                        {{ $post->formatted_views }} Views

                                    </small>

                                </div>

                            </div>

                            <div class="d-flex gap-3 social-links">
                                <span>Share this :</span>
                                @if ($siteSetting?->facebook_url)
                                    <a href="{{ $siteSetting->facebook_url }}" target="_blank">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                @endif

                                @if ($siteSetting?->instagram_url)
                                    <a href="{{ $siteSetting->instagram_url }}" target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                @endif

                                @if ($siteSetting?->youtube_url)
                                    <a href="{{ $siteSetting->youtube_url }}" target="_blank">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

                @if ($post->thumbnail)
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="img-fluid rounded mb-4">
                @endif

                <div class="single-post-content">

                    {!! $post->content !!}

                </div>

                @if (session('success'))
                    <div class="alert alert-success mt-4">

                        {{ session('success') }}

                    </div>
                @endif

                <div class="sidebar-widget mt-5">

                    <h4 class="mb-4">
                        Leave a Comment
                    </h4>

                    <form action="{{ route('frontend.comment.store') }}" method="POST">

                        @csrf

                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <div class="mb-3">

                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>

                        </div>

                        <div class="mb-3">

                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>

                        </div>

                        <div class="mb-3">

                            <textarea name="comment" rows="5" class="form-control" placeholder="Write your comment" required></textarea>

                        </div>

                        <button type="submit" class="btn btn-primary">

                            Submit Comment

                        </button>

                    </form>

                    <div class="sidebar-widget mt-4">

                        <h4 class="mb-4">

                            Comments
                            ({{ $post->comments->count() }})

                        </h4>

                        @forelse($post->comments as $comment)
                            <div class="mb-4">

                                <div class="d-flex gap-3">
                                    <h6 class="text-primary">{{ $comment->name }}</h6>

                                    <small class="text-danger">

                                        {{ $comment->created_at->format('d M Y') }}

                                    </small>
                                </div>

                                <p class="mt-2">

                                    {{ $comment->comment }}

                                </p>

                            </div>

                            <hr>

                        @empty

                            <p>No comments yet.</p>
                        @endforelse

                    </div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="card">

                    <div class="card-header">

                        Recent Posts

                    </div>

                    <div class="card-body">

                        @foreach ($recentPosts as $recent)
                            <div class="mb-3">

                                <a href="{{ route('frontend.post.show', $recent->slug) }}">

                                    {{ $recent->title }}

                                </a>

                            </div>
                        @endforeach

                    </div>

                </div>

                <div class="card mt-4">

                    <div class="card-header">

                        Popular Posts

                    </div>

                    <div class="card-body">

                        @foreach ($popularPosts as $popular)
                            <div class="mb-3">

                                <a href="{{ route('frontend.post.show', $popular->slug) }}">

                                    {{ $popular->title }}

                                </a>

                                <br>

                                <small>

                                    {{ $post->formatted_views }} Views

                                </small>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>



        <div class="card mt-5 authorPart">

            <div class="card-body p-5">

                <div class="d-flex mb-4">
                    <img src="{{ asset('storage/' . $setting->author_image) }}" alt="{{ $setting->author_name }}"
                        class="rounded-circle me-3" width="80" height="80">

                    <div>

                        <h5>

                            {{ $setting->author_name }}

                        </h5>

                        <p class="mb-0">

                            {{ $setting->author_description }}

                        </p>

                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <small class="text-muted">

                        <span>{{ $post->created_at->format('d M Y') }}</span>

                        •

                        <span>{{ $post->reading_time }} min read</span>

                        •

                        <span>{{ $post->formatted_views }} Views</span>

                    </small>

                    <div>

                        <a class="btn btn-sm btn-outline-primary" target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">

                            <i class="fab fa-facebook-f"></i>

                        </a>

                        <a class="btn btn-sm btn-outline-info" target="_blank"
                            href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}">

                            <i class="fab fa-twitter"></i>

                        </a>

                        <a class="btn btn-sm btn-outline-secondary" target="_blank"
                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}">

                            <i class="fab fa-linkedin-in"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <div class="reletedPostPart mt-5">
            <h3 class="mb-4">

                Related Posts

            </h3>

            <div class="row">

                @foreach ($relatedPosts as $related)
                    <div class="col-lg-3">

                        <div class="card h-100">

                            @if ($related->thumbnail)
                                <img src="{{ asset('storage/' . $related->thumbnail) }}" class="card-img-top">
                            @endif

                            <div class="card-body">

                                <a href="{{ route('frontend.post.show', $related->slug) }}">

                                    {{ $related->title }}

                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- destination section  --}}
    <section class="py-5 bg-white">

        <div class="container">

            <div class="row">

                <div class="col-lg-4">

                    <h5 class="section-title">
                        DESTINATIONS
                    </h5>

                    @foreach ($destinationPosts as $post)
                        <div class="small-post">

                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">

                            <div class="d-block">

                                <h6><a href="{{ route('frontend.post.show', $post->slug) }}">

                                        {{ $post->title }}

                                    </a>
                                </h6>

                                <p>

                                    {{ $post->created_at->format('d M Y') }}

                                </p>

                            </div>

                        </div>
                    @endforeach

                </div>

                <div class="col-lg-4">

                    <h5 class="section-title">
                        LIFESTYLE
                    </h5>

                    @foreach ($lifestylePosts as $post)
                        <div class="small-post">

                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">

                            <div class="d-block">

                                <h6>
                                    <a href="{{ route('frontend.post.show', $post->slug) }}">

                                        {{ $post->title }}

                                    </a>
                                </h6>

                                <small>

                                    {{ $post->created_at->format('d M Y') }}

                                </small>

                            </div>

                        </div>
                    @endforeach

                </div>

                <div class="col-lg-4">

                    <h5 class="section-title">
                        PHOTOGRAPHY
                    </h5>

                    @foreach ($photographyPosts as $post)
                        <div class="small-post">

                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">

                            <div class="d-block">

                                <h6>
                                    <a href="{{ route('frontend.post.show', $post->slug) }}">

                                        {{ $post->title }}

                                    </a>
                                </h6>

                                <small>

                                    {{ $post->created_at->format('d M Y') }}

                                </small>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </section>

    {{-- categories section  --}}
    <section class="py-5">

        <div class="container">

            <h5 class="section-title">
                CATEGORIES
            </h5>

            <div class="row g-4">

                <div class="categorySlider owl-carousel owl-theme">

                    @foreach ($categories as $category)
                        <div class="item">

                            <div class="post-card text-center">

                                <a href="{{ route('frontend.category.show', $category->slug) }}">

                                    <img class="post-image-sm" src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}">

                                </a>

                                <div class="post-content">

                                    <h5>

                                        <a href="{{ route('frontend.category.show', $category->slug) }}">

                                            {{ $category->name }}

                                        </a>

                                    </h5>

                                    <small>

                                        {{ $category->posts()->count() }}
                                        Posts

                                    </small>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $('.categorySlider').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 5
                }
            }
        });
    </script>
@endpush
