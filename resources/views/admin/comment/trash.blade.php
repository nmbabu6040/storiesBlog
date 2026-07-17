@extends('admin.layouts.master')

@section('title', 'Comment Trash')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Comment Trash</h3>

        <a href="{{ route('admin.comments.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            @if ($comments->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Post</th>
                                <th>Comment</th>
                                <th>Deleted At</th>
                                <th width="180">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($comments as $comment)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $comment->name }}
                                    </td>

                                    <td>
                                        {{ $comment->post?->title }}
                                    </td>

                                    <td>
                                        {{ Str::limit($comment->comment, 80) }}
                                    </td>

                                    <td>
                                        {{ $comment->deleted_at->diffForHumans() }}
                                    </td>

                                    <td>

                                        <div class="d-flex gap-2">

                                            <form action="{{ route('admin.comments.restore', $comment->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button class="btn btn-success btn-sm"
                                                    onclick="return confirm('Restore this comment?')">

                                                    <i class="fas fa-undo"></i>

                                                </button>

                                            </form>

                                            <form action="{{ route('admin.comments.forceDelete', $comment->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete permanently?')">

                                                    <i class="fas fa-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $comments->links() }}
                </div>
            @else
                <div class="text-center py-5">

                    <h5 class="text-muted">

                        No trashed comments found.

                    </h5>

                </div>

            @endif

        </div>
    </div>

@endsection
