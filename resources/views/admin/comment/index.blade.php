@extends('admin.layouts.master')

@section('title', 'Comments')

@section('content')

    <h3 class="mb-4">
        Comments
    </h3>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Name</th>

                <th>Post</th>

                <th>Comment</th>

                <th>Status</th>

                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($comments as $comment)
                <tr>

                    <td>

                        {{ $comment->name }}

                    </td>

                    <td>

                        {{ $comment->post->title }}

                    </td>

                    <td>

                        {{ $comment->comment }}

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

                        @if (!$comment->status)
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="d-inline">

                                @csrf

                                <button class="btn btn-success btn-sm">

                                    Approve

                                </button>

                            </form>
                        @endif

                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

@endsection
