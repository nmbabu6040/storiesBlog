@extends('frontend.layouts.master')

@section('content')
    {{-- hero section  --}}
    <section class="hero-section">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 align-self-center">

                    <p class="text-primary">

                        <span class="typewrite" data-type='@json($heroTypes)' data-period="2000">
                        </span>

                    </p>

                    <h2 class="fw-bold">

                        Hello, I'm

                        <span>

                            {{ $setting->author_name }}

                        </span>

                    </h2>

                    <h2 class="fw-bold mb-4">

                        {{ $setting->hero_title }}

                    </h2>

                    <h5 class="text-muted mb-5">

                        {{ $setting->hero_subtitle }}

                    </h5>

                    <form action="{{ route('frontend.subscribe') }}" method="POST"
                        class="input-group form-subcriber mt-30 d-flex">

                        @csrf

                        <input type="text" name="name" class="form-control nameInput" placeholder="Your Name"
                            required>

                        <input type="email" name="email" class="form-control bg-white font-small"
                            placeholder="Enter your email" required>

                        <button class="btn bg-primary text-white" type="submit">

                            Subscribe

                        </button>

                    </form>

                </div>

                <div class="col-lg-6 text-end d-none d-lg-block">

                    <img src="{{ asset('storage/' . $setting->hero_image) }}" alt="Hero Image">

                </div>

            </div>

        </div>

    </section>

    {{-- feacherd section  --}}
    <section class="featured-section">

        <div class="container">

            <h5 class="section-title">
                FEATURED POSTS
            </h5>

            <div class="row">

                {{-- @if ($featuredPosts->count())

                    <div class="col-lg-8">

                        @php
                            $mainPost = $featuredPosts->first();
                        @endphp

                        <div class="featuresdSlider owl-carousel">
                            <div class="post-card featured-large">

                                <a href="{{ route('frontend.post.show', $mainPost->slug) }}">

                                    <img src="{{ asset('storage/' . $mainPost->thumbnail) }}"
                                        class="post-image featured-main-image">

                                </a>

                                <div class="post-content">

                                    <span class="post-category">

                                        {{ $mainPost->category->name }}

                                    </span>

                                    <h3 class="post-title">

                                        <a href="{{ route('frontend.post.show', $mainPost->slug) }}">

                                            {{ $mainPost->title }}

                                        </a>

                                    </h3>

                                    <div class="postPublishTime d-flex gap-4">

                                        <h6 class="fw-bold text-drak">{{ $mainPost->created_at->diffForHumans() }}</h6>

                                        <h6 class="fw-bold text-drak">{{ $mainPost->views }} views</h6>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        @foreach ($featuredPosts->skip(1) as $post)
                            <div class="small-featured-card">

                                <a href="{{ route('frontend.post.show', $post->slug) }}">

                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="post-image-sm">

                                </a>

                                <div class="post-content">

                                    <span class="post-category">

                                        {{ $post->category->name }}

                                    </span>

                                    <h5>

                                        <a href="{{ route('frontend.post.show', $post->slug) }}">

                                            {{ $post->title }}

                                        </a>

                                    </h5>

                                </div>

                            </div>
                        @endforeach

                    </div>

                @endif --}}

                @if ($featuredPosts->count())
                    <div class="col-lg-8">

                        @php
                            $mainPost = $featuredPosts->first();
                        @endphp

                        <div class="featuresdSlider owl-carousel owl-theme">

                            @foreach ($featuredPosts as $post)
                                <div class="item">

                                    <div class="post-card featured-large">

                                        <a href="{{ route('frontend.post.show', $post->slug) }}">

                                            <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                                class="post-image featured-main-image" alt="{{ $post->title }}">

                                        </a>

                                        <div class="post-content">

                                            <span class="post-category">

                                                {{ $post->category->name }}

                                            </span>

                                            <h3 class="post-title">

                                                <a href="{{ route('frontend.post.show', $post->slug) }}">

                                                    {{ $post->title }}

                                                </a>

                                            </h3>

                                            <div class="postPublishTime d-flex gap-4">

                                                <h6>{{ $post->created_at->diffForHumans() }}</h6>

                                                <h6>{{ number_format($post->views) }} Views</h6>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="col-lg-4">

                        @foreach ($featuredPosts->skip(1) as $post)
                            <div class="small-featured-card">

                                <a href="{{ route('frontend.post.show', $post->slug) }}">

                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="post-image-sm">

                                </a>

                                <div class="post-content">

                                    <span class="post-category">

                                        {{ $post->category->name }}

                                    </span>

                                    <h5>

                                        <a href="{{ route('frontend.post.show', $post->slug) }}">

                                            {{ $post->title }}

                                        </a>

                                    </h5>

                                    <div class="postPublishTime d-flex align-items-center gap-4">

                                        <h6>{{ $post->created_at->diffForHumans() }}</h6>

                                        •

                                        <h6>{{ $post->reading_time }} min read</h6>

                                        •

                                        <h6>{{ number_format($post->views) }} Views</h6>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @endif

            </div>

        </div>

    </section>

    {{-- travel section  --}}
    <section class="travel-section">

        <div class="container">

            <div class="row">

                <div class="col-lg-8">

                    <h5 class="section-title">
                        TRAVEL TIPS
                    </h5>

                    <div class="row g-4">

                        @foreach ($travelPosts as $post)
                            <div class="col-lg-6">

                                <div class="post-card">

                                    <img class="post-image-sm" src="{{ asset('storage/' . $post->thumbnail) }}"
                                        alt="{{ $post->title }}">

                                    <div class="post-content">

                                        <span class="post-category ">

                                            {{ $post->category->name }}

                                        </span>

                                        <h5 class="post-title">

                                            <a href="{{ route('frontend.post.show', $post->slug) }}">

                                                {{ $post->title }}

                                            </a>

                                        </h5>

                                        <p class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 80) }}

                                        </p>

                                        <small class="text-muted">

                                            <span>{{ $post->created_at->format('d M Y') }}</span>

                                            •

                                            <span>{{ $post->reading_time }} min read</span>

                                            •

                                            <span>{{ $post->formatted_views }} Views</span>

                                        </small>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="sidebar-widget text-center">

                        @if (!empty($siteSetting->author_image))
                            <img class="author-img mb-3" src="{{ asset('storage/' . $siteSetting->author_image) }}">
                        @endif

                        <h4>

                            {{ $siteSetting->author_name }}

                        </h4>

                        <p>

                            {{ $siteSetting->author_description }}

                        </p>

                    </div>
                    @if ($sidebarAd)
                        <div class="sidebar-widget mb-4">

                            @if ($sidebarAd->type == 'image')
                                <a href="{{ $sidebarAd->url }}" target="_blank">

                                    <img src="{{ asset('storage/' . $sidebarAd->image) }}" class="img-fluid rounded">

                                </a>
                            @else
                                {!! $sidebarAd->code !!}
                            @endif

                        </div>
                    @endif
                    <div class="sidebar-widget">

                        <h5 class="mb-4">
                            MOST POPULAR
                        </h5>

                        @foreach ($popularPosts as $post)
                            <div class="small-post">

                                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">

                                <div>

                                    <h6>

                                        <a href="{{ route('frontend.post.show', $post->slug) }}">

                                            {{ $post->title }}

                                        </a>

                                    </h6>

                                    <small>

                                        {{ $post->created_at->format('d M Y') }}

                                        {{ $post->formatted_views }} Views

                                    </small>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- latest post section  --}}
    <section class="pb-5 latest_section">

        <div class="container">

            <div class="row mt-5">

                <div class="col-lg-8">

                    <h5 class="section-title">
                        LATEST POSTS
                    </h5>

                    @foreach ($latestPosts as $post)
                        <div class="latest-post-item">

                            <div class="row align-items-center">

                                <div class="col-md-3">

                                    <a href="{{ route('frontend.post.show', $post->slug) }}">

                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="latest-post-image">

                                    </a>

                                </div>

                                <div class="col-md-9">

                                    <span class="post-category">

                                        {{ $post->category->name }}

                                    </span>

                                    <h4 class="latest-post-title">

                                        <a href="{{ route('frontend.post.show', $post->slug) }}">

                                            {{ $post->title }}

                                        </a>

                                    </h4>

                                    <div class="post-meta">

                                        {{ $post->created_at->format('d M Y') }}

                                        .

                                        {{ $post->reading_time }} min read

                                        .

                                        {{ $post->formatted_views }} Views

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                <div class="col-lg-4">

                    <div class="sidebar-widget">

                        <h5 class="mb-4">
                            LATEST COMMENTS
                        </h5>

                        @forelse($latestComments as $comment)
                            <div class="small-post mb-3">

                                <div>

                                    <strong>

                                        <span class="text-capitalize">
                                            {{ $comment->name }}
                                        </span>

                                        .

                                        <span class="text-secondary">
                                            {{ $comment->created_at->format('d M Y') }}
                                        </span>

                                    </strong>

                                    <p class="mb-1 small">

                                        {{ \Illuminate\Support\Str::limit($comment->comment, 60) }}

                                    </p>

                                    <small class="text-muted">

                                        on

                                        <a href="{{ route('frontend.post.show', $comment->post->slug) }}">

                                            {{ \Illuminate\Support\Str::limit($comment->post->title, 30) }}

                                        </a>

                                    </small>

                                </div>

                            </div>

                            <hr>

                        @empty

                            <p class="text-muted">

                                No comments yet

                            </p>
                        @endforelse

                    </div>


                    <div class="sidebar-widget">

                        <h5 class="mb-4">
                            INSTAGRAM
                        </h5>

                        <div class="instagram-gallery">

                            <div class="row g-2">

                                @foreach ($galleryImages as $image)
                                    <div class="col-4">

                                        <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded"
                                            alt="Instagram Gallery">

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>


    @include('frontend.partials.destination-section')



    @include('frontend.partials.category-slider')
@endsection

{{-- @push('scripts')
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
@endpush --}}
@push('scripts')
    <script>
        $('.featuresdSlider').owlCarousel({

            items: 1,

            loop: true,

            autoplay: true,

            autoplayTimeout: 4000,

            smartSpeed: 1000,

            animateOut: 'fadeOut',

            animateIn: 'fadeIn',

            mouseDrag: false,

            touchDrag: true,

            nav: false,

            dots: false

        });
    </script>
@endpush
