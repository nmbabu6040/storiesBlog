{{-- destination section  --}}
<section class="dastination_section  py-5 bg-white">

    <div class="container">

        <div class="row">

            <div class="col-lg-4">

                <h5 class="section-title">
                    DESTINATIONS
                </h5>

                @foreach ($destinationPosts as $post)
                    <div class="small-post">

                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">

                        <div>

                            <a href="{{ route('frontend.post.show', $post->slug) }}">

                                {{ $post->title }}

                            </a>

                            <div class="post-meta">

                                {{ $post->created_at->format('d M Y') }}

                                .

                                {{ $post->reading_time }} min read

                                .

                                {{ $post->formatted_views }} Views

                            </div>

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

                        <div>

                            <a href="{{ route('frontend.post.show', $post->slug) }}">

                                {{ $post->title }}

                            </a>

                            <div class="post-meta">

                                {{ $post->created_at->format('d M Y') }}

                                .

                                {{ $post->reading_time }} min read

                                .

                                {{ $post->formatted_views }} Views

                            </div>

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

                        <div>

                            <a href="{{ route('frontend.post.show', $post->slug) }}">

                                {{ $post->title }}

                            </a>

                            <div class="post-meta">

                                {{ $post->created_at->format('d M Y') }}

                                .

                                {{ $post->reading_time }} min read

                                .

                                {{ $post->formatted_views }} Views

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

</section>
