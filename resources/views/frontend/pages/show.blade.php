@extends('frontend.layouts.master')

@section('title', $page->meta_title ?: $page->title)

@section('meta_description', $page->meta_description)

@section('meta_keywords', $page->meta_keywords)

@section('content')

    <section class="page-banner mt-5">

        <div class="container">
            @if ($page->banner_image)
                <img src="{{ asset('storage/' . $page->banner_image) }}" class="img-fluid w-100 rounded" alt="">
            @endif
        </div>

    </section>

    <section class="container py-5">

        <div class="text-center">
            <h1 class="mb-4">

                {{ $page->title }}

            </h1>

            @if ($page->slug == 'about')
                <p class="text-primary">

                    <span class="typewrite" data-type='@json($heroTypes)' data-period="2000">
                    </span>

                </p>
            @endif

        </div>
        <div class="page-content mb-5">

            {!! $page->content !!}

        </div>

        @if ($page->slug == 'blog')

            <div class="row mt-5">

                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">

                        <div class="card h-100">

                            @if ($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top">
                            @endif

                            <div class="card-body">

                                <h5 class="card-title">

                                    <a href="{{ route('frontend.post.show', $post->slug) }}">

                                        {{ $post->title }}

                                    </a>

                                </h5>

                                <p class="card-text">

                                    {{ $post->excerpt }}

                                </p>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        @endif



        @if ($page->slug == 'contact' || $page->slug == 'about')

            <div class="row mt-5">

                <div class="col-lg-5">

                    <div class="card shadow-sm border-0 h-100">

                        <div class="card-body p-4">

                            <h3 class="mb-4">

                                Contact Information

                            </h3>

                            @if ($setting->address)
                                <div class="mb-4 d-flex gap-2">

                                    <strong>Address:</strong>

                                    <p class="mb-0">

                                        {!! nl2br(e($setting->address)) !!}

                                    </p>

                                </div>
                            @endif

                            @if ($setting->phone)
                                <div class="mb-4 d-flex gap-2">

                                    <strong>Phone:</strong>

                                    <a href="tel:{{ $setting->phone }}" class="text-dark">

                                        {{ $setting->phone }}

                                    </a>

                                </div>
                            @endif

                            @if ($setting->email)
                                <div class="mb-4 d-flex gap-2">

                                    <strong>Email:</strong>

                                    <a href="mailto:{{ $setting->email }}" class="text-dark">

                                        {{ $setting->email }}

                                    </a>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                <div class="col-lg-7">

                    @if (session('success'))
                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>
                    @endif

                    <form action="{{ route('frontend.contact.submit') }}" method="POST">

                        @csrf

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <input type="text" name="name" class="form-control" placeholder="Your Name"
                                    value="{{ old('name') }}" required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <input type="email" name="email" class="form-control" placeholder="Your Email"
                                    value="{{ old('email') }}" required>

                            </div>

                        </div>

                        <div class="mb-3">

                            <input type="text" name="subject" class="form-control" placeholder="Subject"
                                value="{{ old('subject') }}">

                        </div>

                        <div class="mb-3">

                            <textarea name="message" rows="6" class="form-control" placeholder="Message" required>{{ old('message') }}</textarea>

                        </div>

                        <button class="btn btn-primary px-4">

                            Send Message

                        </button>

                    </form>

                </div>

            </div>

            @if ($setting->google_map)
                <div class="mt-5 w-100">

                    {!! $setting->google_map !!}

                </div>
            @endif

        @endif

    </section>

    @include('frontend.partials.destination-section')

    @include('frontend.partials.category-slider')

@endsection
