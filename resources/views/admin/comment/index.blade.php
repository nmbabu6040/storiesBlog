@extends('admin.layouts.master')

@section('title', 'Comments')

@section('content')

    <h3 class="mb-4">
        Comments
    </h3>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.comments.trash') }}" class="btn btn-warning mb-3">
            Trash
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>#</th>

                <th>User</th>

                <th>Post</th>

                <th>Comment</th>

                <th>Replies</th>

                <th>Status</th>

                <th>Date</th>

                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($comments as $comment)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        <strong>{{ $comment->name }}</strong>

                        <br>

                        <small>{{ $comment->email }}</small>

                    </td>

                    <td>

                        {{ $comment->post->title }}

                    </td>

                    <td width="350">

                        {{ Str::limit($comment->comment, 100) }}

                    </td>

                    <td>

                        <span class="badge bg-info">

                            {{ $comment->replies->count() }}

                        </span>

                    </td>

                    <td>

                        @if ($comment->status)
                            <span class="badge bg-success">

                                Approved

                            </span>
                        @else
                            <span class="badge bg-warning">

                                Pending

                            </span>
                        @endif

                    </td>

                    <td>

                        {{ $comment->created_at->format('d M Y') }}

                    </td>

                    <td class="d-flex gap-2">

                        @if (!$comment->status)
                            <form method="POST" action="{{ route('admin.comments.approve', $comment) }}" class="d-inline">

                                @csrf

                                <button class="btn btn-success btn-sm">

                                    Approve

                                </button>

                            </form>
                        @endif

                        <a href="{{ route('admin.comments.reply', $comment) }}" class="btn btn-primary btn-sm">

                            Reply

                        </a>

                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button onclick="return confirm('Delete comment?')" class="btn btn-danger btn-sm">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
    <div class="mt-3">

        {{ $comments->links() }}

    </div>

@endsection
