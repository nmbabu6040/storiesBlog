@extends('frontend.layouts.master')

@section('title', $post->meta_title ?: $post->title)

@section('meta_description', $post->meta_description)

{{-- @section('meta_keywords', $post->meta_keywords) --}}

@if ($beforePostAd)

    <div class="my-4 text-center">

        @if ($beforePostAd->type == 'image')
            <a href="{{ $beforePostAd->url }}" target="_blank">

                <img src="{{ asset('storage/' . $beforePostAd->image) }}" class="img-fluid">

            </a>
        @else
            {!! $beforePostAd->code !!}
        @endif

    </div>

@endif

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

                        @if ($post->tags->count())

                            <div class="mb-4">

                                <strong class="me-2">

                                    Tags :

                                </strong>

                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('frontend.tag.show', $tag->slug) }}"
                                        class="badge bg-primary text-decoration-none me-2">

                                        {{ $tag->name }}

                                    </a>
                                @endforeach

                            </div>

                        @endif
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

                {{-- comment part start  --}}
                <div class="sidebar-widget mt-5">

                    <h4 class="mb-4">
                        Leave a Comment
                    </h4>

                    @if (session('success'))
                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @auth

                        <div id="commentMessage"></div>
                        <form id="commentForm" action="{{ route('frontend.comment.store') }}" method="POST">

                            @csrf

                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                            <input type="hidden" name="parent_id" id="parent_id" value="">

                            <div class="mb-3">

                                <label class="form-label">

                                    Your Comment

                                </label>

                                <div id="replyInfo" class="alert alert-info d-none mb-3"></div>

                                <textarea name="comment" rows="5" class="form-control" placeholder="Write your comment..." required>{{ old('comment') }}</textarea>

                                @error('comment')
                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>
                                @enderror

                            </div>

                            <button class="btn btn-primary">

                                Post Comment

                            </button>

                        </form>
                    @else
                        <div class="alert alert-info">

                            <h5 class="mb-2">

                                Join the Discussion

                            </h5>

                            <p class="mb-3">

                                Please login or create an account to post a comment.

                            </p>

                            <a href="{{ route('login') }}" class="btn btn-primary me-2">

                                Login

                            </a>

                            <a href="{{ route('register') }}" class="btn btn-outline-primary">

                                Register

                            </a>

                        </div>

                    @endauth

                </div>

                {{-- comment part end start --}}
                <div class="sidebar-widget mt-5" id="commentsWrapper">

                    <h4 class="mb-4">

                        Comments ({{ $post->comments->count() }})

                    </h4>

                    @include('frontend.partials.comments')

                </div>

            </div>

            {{-- recent and populer post part  --}}
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

                                    {{ $popular->formatted_views }} Views

                                </small>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>


        {{-- author part start  --}}
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
        {{-- releted post part  --}}
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
    @include('frontend.partials.destination-section')

    {{-- categories section  --}}
    @include('frontend.partials.category-slider')
@endsection
@if ($afterPostAd)

    <div class="my-4 text-center">

        @if ($afterPostAd->type == 'image')
            <a href="{{ $afterPostAd->url }}" target="_blank">

                <img src="{{ asset('storage/' . $afterPostAd->image) }}" class="img-fluid">

            </a>
        @else
            {!! $afterPostAd->code !!}
        @endif

    </div>

@endif

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

    <script>
        $('#commentForm').submit(function(e) {

            e.preventDefault();

            let form = $(this);

            $.ajax({

                url: form.attr('action'),

                method: 'POST',

                data: form.serialize(),

                success: function(res) {

                    $('#commentMessage').html(

                        '<div class="alert alert-success">' + res.message + '</div>'

                    );

                    form.trigger('reset');

                    $('#parent_id').val('');

                    $('#replyInfo').addClass('d-none');

                },

                error: function(xhr) {

                    $('#commentMessage').html(

                        '<div class="alert alert-danger">Something went wrong.</div>'

                    );

                }

            });

        });
    </script>

    <script>
        function loadComments() {

            $("#commentsList").load(

                "{{ route('frontend.comments.load', $post->id) }}"

            );

        }

        setInterval(loadComments, 30000);
    </script>

    <script>
        document.querySelectorAll('.reply-btn').forEach(button => {

            button.addEventListener('click', function() {

                document.getElementById('parent_id').value = this.dataset.id;

                let info = document.getElementById('replyInfo');

                info.classList.remove('d-none');

                info.innerHTML =
                    'Replying to <strong>' + this.dataset.name +
                    '</strong> <a href="#" id="cancelReply" class="ms-2">Cancel</a>';

                document.querySelector('textarea[name=comment]').focus();

                window.scrollTo({

                    top: document.querySelector('textarea[name=comment]').offsetTop - 120,

                    behavior: 'smooth'

                });

            });

        });

        document.addEventListener('click', function(e) {

            if (e.target.id === 'cancelReply') {

                e.preventDefault();

                document.getElementById('parent_id').value = '';

                document.getElementById('replyInfo').classList.add('d-none');

            }

        });
    </script>
@endpush
