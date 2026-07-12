@extends('admin.layouts.master')

@section('title', 'Trash Posts')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0">

            Trash Posts

        </h3>

        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="70">#</th>

                        <th width="90">Image</th>

                        <th>Title</th>

                        <th>Category</th>

                        <th width="180">Deleted At</th>

                        <th width="200">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($posts as $post)
                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                @if ($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}" width="70" class="rounded">
                                @endif

                            </td>

                            <td>

                                {{ $post->title }}

                            </td>

                            <td>

                                {{ $post->category?->name }}

                            </td>

                            <td>

                                {{ $post->deleted_at->format('d M, Y h:i A') }}

                            </td>

                            <td>

                                <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.posts.forceDelete', $post->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Permanently delete this post?')">

                                    @csrf

                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete Forever

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                Trash is empty.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">

                {{ $posts->links() }}

            </div>

        </div>

    </div>

@endsection
