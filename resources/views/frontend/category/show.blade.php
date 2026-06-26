@extends('frontend.layouts.master')

@section('title', $category->name)

@section('meta_description', 'Browse all posts from ' . $category->name)

@section('content')
    <div class="container py-5">

        <h2 class="mb-4">

            {{ $category->name }}

        </h2>

        <div class="row">

            @foreach ($posts as $post)
                <div class="col-md-4 mb-4">

                    <div class="card h-100">

                        @if ($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top">
                        @endif

                        <div class="card-body">

                            <h5>

                                <a href="{{ route('frontend.post.show', $post->slug) }}">

                                    {{ $post->title }}

                                </a>

                            </h5>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

        {{ $posts->links() }}

    </div>
@endsection
