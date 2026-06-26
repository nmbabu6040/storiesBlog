@extends('admin.layouts.master')

@section('title', 'Posts')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">

        <h3>Posts</h3>

        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">

            Add Post

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            {{-- @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif --}}

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($posts as $post)
                        <tr>

                            <td>{{ $post->id }}</td>

                            <td>

                                @if ($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" width="80">
                                @endif

                            </td>

                            <td>
                                {{ $post->category->name ?? '-' }}
                            </td>

                            <td>
                                {{ $post->title }}
                            </td>

                            <td>
                                {{ $post->views }}
                            </td>

                            <td>

                                @if ($post->status)
                                    <span class="badge bg-success">
                                        Published
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Draft
                                    </span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Delete this post?')"
                                        class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No Post Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
