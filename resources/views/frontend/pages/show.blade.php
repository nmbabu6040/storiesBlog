@extends('frontend.layouts.master')

@section('title', $page->meta_title ?: $page->title)

@section('meta_description', $page->meta_description)

@section('meta_keywords', $page->meta_keywords)

@section('content')

    <section class="page-banner">

        @if ($page->banner_image)
            <img src="{{ asset('storage/' . $page->banner_image) }}" class="img-fluid w-100" alt="{{ $page->title }}">
        @endif

    </section>

    <section class="container py-5">

        <h1 class="mb-4">

            {{ $page->title }}

        </h1>

        <div class="page-content mb-5">

            {!! $page->content !!}

        </div>

        @if ($page->slug == 'contact')

            <div class="row mt-5">

                <div class="col-lg-5">

                    <div class="card shadow-sm border-0 h-100">

                        <div class="card-body p-4">

                            <h3 class="mb-4">

                                Contact Information

                            </h3>

                            @if ($setting->address)
                                <div class="mb-4">

                                    <h6>Address</h6>

                                    <p class="mb-0">

                                        {!! nl2br(e($setting->address)) !!}

                                    </p>

                                </div>
                            @endif

                            @if ($setting->phone)
                                <div class="mb-4">

                                    <h6>Phone</h6>

                                    <a href="tel:{{ $setting->phone }}">

                                        {{ $setting->phone }}

                                    </a>

                                </div>
                            @endif

                            @if ($setting->email)
                                <div class="mb-4">

                                    <h6>Email</h6>

                                    <a href="mailto:{{ $setting->email }}">

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
                <div class="mt-5">

                    {!! $setting->google_map !!}

                </div>
            @endif

        @endif

    </section>

    @include('frontend.partials.destination-section')

    @include('frontend.partials.category-slider')

@endsection
