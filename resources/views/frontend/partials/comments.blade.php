@forelse($post->comments()->whereNull('parent_id')->where('status',1)->latest()->get() as $comment)

    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center">

            <h6 class="text-primary mb-0">

                {{ $comment->name }}

            </h6>

            <small class="text-muted">

                {{ $comment->created_at->format('d M, Y') }}

            </small>

        </div>

        <p class="mt-3 mb-0">

            {{ $comment->comment }}

        </p>

        @if ($comment->replies->count())
            <div class="ms-5 mt-3">

                @foreach ($comment->replies as $reply)
                    <div class="border-start ps-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong class="text-success">
                                {{ $reply->name }}

                                @if ($reply->email == config('mail.from.address'))
                                    <span class="badge bg-primary ms-1">Admin</span>
                                @endif
                            </strong>

                            <small>

                                {{ $reply->created_at->format('d M, Y') }}

                            </small>

                        </div>

                        <p class="mb-0">

                            {{ $reply->comment }}

                        </p>

                    </div>
                @endforeach

            </div>
        @endif

        @auth
            <button type="button" class="btn btn-sm btn-link p-0 mt-2 reply-btn" data-id="{{ $comment->id }}"
                data-name="{{ $comment->name }}">
                Reply to {{ $comment->name }}
            </button>
        @endauth

    </div>

    @if (!$loop->last)
        <hr>
    @endif


@empty

    <div class="alert alert-light border">

        No comments yet.

    </div>
@endforelse
