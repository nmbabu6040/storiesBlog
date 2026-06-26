@extends('frontend.layouts.master')

@section('content')
    <div class="container py-5">

        <h2 class="mb-4">

            Search Result :
            {{ $keyword }}

        </h2>

        <div class="row">

            @forelse($posts as $post)
                <div class="col-md-4 mb-4">

                    <div class="post-card">

                        @if ($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="post-image-sm">
                        @endif

                        <div class="post-content">

                            <h5>

                                <a href="{{ route('frontend.post.show', $post->slug) }}">

                                    {{ $post->title }}

                                </a>

                            </h5>

                        </div>

                    </div>

                </div>

            @empty

                <div class="alert alert-warning">
                    No Post Found
                </div>
            @endforelse

        </div>

        {{ $posts->links() }}

    </div>
@endsection
