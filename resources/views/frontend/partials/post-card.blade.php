<div class="row">

    @forelse($posts as $post)
        <div class="col-lg-12 mb-4">

            <div class="card h-100">

                @if ($post->thumbnail)
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif

                <div class="card-body">

                    <h5 class="card-title">

                        <a href="{{ route('frontend.post.show', $post->slug) }}" class="text-decoration-none">

                            {{ $post->title }}

                        </a>

                    </h5>

                    <p class="text-muted small">

                        {{ $post->created_at->format('d M, Y') }}

                    </p>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-info">

                No Posts Found.

            </div>

        </div>
    @endforelse

</div>

<div class="mt-4">

    {{ $posts->links() }}

</div>
