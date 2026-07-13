@extends('frontend.layouts.master')

@section('title', $tag->name)

@section('content')

    <div class="container py-5">

        <h2 class="mb-4">

            Tag: {{ $tag->name }}

        </h2>

        <div class="row">

            @forelse($posts as $post)
                <div class="col-lg-4 mb-4">

                    @include('frontend.partials.post-card')

                </div>

            @empty

                <div class="col-12">

                    No Posts Found.

                </div>
            @endforelse

        </div>

        {{ $posts->links() }}

    </div>

@endsection
