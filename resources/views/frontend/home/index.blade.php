@extends('layouts.master')

@section('title')
    Stories Blog
@endsection

@section('content')
    {{-- hero section  --}}
    <section class="hero-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <div class="hero-subtitle">

                        Food Guides

                    </div>

                    <h1 class="hero-title">

                        Hello, I'm

                        <span>Steven</span>

                        Welcome to my blog

                    </h1>

                    <p class="hero-description">

                        Don't miss out on the latest news
                        about Travel tips, Hotels review,
                        Food guide and more.

                    </p>

                    <form class="subscribe-form">

                        <div class="input-group">

                            <input type="email" class="form-control" placeholder="Enter your email">

                            <button class="btn btn-primary">

                                Subscribe

                            </button>

                        </div>

                    </form>

                </div>

                <div class="col-lg-6">

                    <div class="hero-image text-center">

                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=1200" alt="Hero">

                    </div>

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

            <div class="row g-4">

                <div class="col-lg-8">

                    <div class="post-card">

                        <img class="post-image" src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=1400"
                            alt="">

                        <div class="post-content">

                            <span class="post-category">
                                Travel
                            </span>

                            <h2 class="post-title">
                                Beachmaster Elephant Seal Fights
                                of Rival Male
                            </h2>

                            <div class="post-meta">
                                20 MIN READ • 3K VIEWS
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="post-card">

                        <img class="post-image-sm"
                            src="https://images.unsplash.com/photo-1482049016688-2d3e1b311543?q=80&w=1000" alt="">

                        <div class="post-content">

                            <span class="post-category">
                                Food
                            </span>

                            <h4 class="post-title-sm">
                                Want fluffy Japanese pancakes
                                but can't fly to Tokyo?
                            </h4>

                        </div>

                    </div>

                </div>

            </div>

            <div class="row mt-4 g-4">

                <div class="col-lg-4">

                    <div class="post-card">

                        <img class="post-image-sm"
                            src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=1000">

                        <div class="post-content">

                            <span class="post-category">
                                Fashion
                            </span>

                            <h5>
                                Put Yourself In Your
                                Customers Shoes
                            </h5>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="post-card">

                        <img class="post-image-sm"
                            src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1000">

                        <div class="post-content">

                            <span class="post-category">
                                Travel
                            </span>

                            <h5>
                                Life and Death in the
                                Empire of the Tiger
                            </h5>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="post-card">

                        <img class="post-image-sm"
                            src="https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?q=80&w=1000">

                        <div class="post-content">

                            <span class="post-category">
                                Lifestyle
                            </span>

                            <h5>
                                When Two Wheels Are Better
                                Than Four
                            </h5>

                        </div>

                    </div>

                </div>

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

                        @for ($i = 1; $i <= 4; $i++)
                            <div class="col-lg-6">

                                <div class="post-card">

                                    <img class="post-image-sm"
                                        src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1000">

                                    <div class="post-content">

                                        <span class="post-category">
                                            Travel
                                        </span>

                                        <h5>
                                            Easy Ways To Use
                                            Alternatives to Plastic
                                        </h5>

                                        <p class="text-muted">

                                            Creating alternatives to plastic
                                            can be a game changer.

                                        </p>

                                    </div>

                                </div>

                            </div>
                        @endfor

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="sidebar-widget text-center">

                        <img class="author-img mb-3"
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600">

                        <h4>Hello, I'm Steven</h4>

                        <p>

                            Hi, I'm Steven, a Florida native
                            who left my career in corporate
                            wealth management.

                        </p>

                    </div>

                    <div class="sidebar-widget">

                        <h5 class="mb-4">
                            MOST POPULAR
                        </h5>

                        <div class="small-post">

                            <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=500">

                            <div>

                                <h6>
                                    Spending Some Quality
                                    Time With Kids
                                </h6>

                                <small>
                                    8 AUGUST
                                </small>

                            </div>

                        </div>

                        <div class="small-post">

                            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=500">

                            <div>

                                <h6>
                                    Relationship Podcasts
                                    Are Having That Talk
                                </h6>

                                <small>
                                    9 AUGUST
                                </small>

                            </div>

                        </div>

                        <div class="small-post">

                            <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=500">

                            <div>

                                <h6>
                                    Here's How To Get
                                    Best Sleep At Night
                                </h6>

                                <small>
                                    10 AUGUST
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- latest post section  --}}
    <section class="pb-5">

        <div class="container">

            <div class="row">

                <div class="col-lg-8">

                    <h5 class="section-title">
                        LATEST POSTS
                    </h5>

                    @for ($i = 1; $i <= 4; $i++)
                        <div class="latest-post">

                            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1000">

                            <div>

                                <span class="post-category">
                                    Food
                                </span>

                                <h5>
                                    Helpful Tips for Working
                                    from Home as a Freelancer
                                </h5>

                                <p class="text-muted">

                                    7 AUGUST • 3 MIN READ

                                </p>

                            </div>

                        </div>
                    @endfor

                    <nav>

                        <ul class="pagination">

                            <li class="page-item active">
                                <a class="page-link" href="#">
                                    01
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    02
                                </a>
                            </li>

                            <li class="page-item">
                                <a class="page-link" href="#">
                                    03
                                </a>
                            </li>

                        </ul>

                    </nav>

                </div>
                <div class="col-lg-4">

                    <h5 class="section-title">
                        LAST COMMENTS
                    </h5>

                    @for ($i = 1; $i <= 3; $i++)
                        <div class="comment-box">

                            <div class="d-flex">

                                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600">

                                <div class="ms-3">

                                    <h6>
                                        David
                                    </h6>

                                    <p class="small text-muted">

                                        A writer is someone for
                                        whom writing is difficult.

                                    </p>

                                </div>

                            </div>

                        </div>
                    @endfor

                    <h5 class="section-title mt-5">
                        INSTAGRAM
                    </h5>

                    <div class="instagram-grid">

                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=600">

                        <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=600">

                        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=600">

                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=600">

                        <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=600">

                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=600">

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- destination section  --}}
    <section class="py-5 bg-white">

        <div class="container">

            <div class="row">

                <div class="col-lg-4">

                    <h5 class="section-title">
                        DESTINATIONS
                    </h5>

                    @for ($i = 1; $i <= 4; $i++)
                        <div class="footer-post">

                            <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=600">

                            <div>

                                <h6>
                                    The Best Time To Travel
                                    To Cambodia
                                </h6>

                                <small>
                                    7 AUGUST
                                </small>

                            </div>

                        </div>
                    @endfor

                </div>

                <div class="col-lg-4">

                    <h5 class="section-title">
                        LIFESTYLE
                    </h5>

                    @for ($i = 1; $i <= 4; $i++)
                        <div class="footer-post">

                            <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=600">

                            <div>

                                <h6>
                                    10 Ways To De-Stress
                                    Your Day
                                </h6>

                                <small>
                                    11 AUGUST
                                </small>

                            </div>

                        </div>
                    @endfor

                </div>

                <div class="col-lg-4">

                    <h5 class="section-title">
                        PHOTOGRAPHY
                    </h5>

                    @for ($i = 1; $i <= 4; $i++)
                        <div class="footer-post">

                            <img src="https://images.unsplash.com/photo-1494526585095-c41746248156?q=80&w=600">

                            <div>

                                <h6>
                                    Which Preset Pack Is
                                    Right For You
                                </h6>

                                <small>
                                    12 AUGUST
                                </small>

                            </div>

                        </div>
                    @endfor

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

                <div class="col-lg-4">

                    <div class="sidebar-widget">

                        <h5>Foody</h5>

                        <p class="mb-0">
                            Lorem ipsum dolor sit amet.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="sidebar-widget">

                        <h5>Entertainment</h5>

                        <p class="mb-0">
                            Lorem ipsum dolor sit amet.
                        </p>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="sidebar-widget">

                        <h5>Travel Tips</h5>

                        <p class="mb-0">
                            Lorem ipsum dolor sit amet.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection
