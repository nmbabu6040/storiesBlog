@extends('admin.layouts.master')

@section('title', 'Trash Tags')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>Trash Tags</h3>

        <a href="{{ route('admin.tags.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Name</th>

                        <th>Slug</th>

                        <th>Deleted At</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($trashTags as $tag)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $tag->name }}</td>

                            <td>{{ $tag->slug }}</td>

                            <td>{{ $tag->deleted_at->format('d M Y h:i A') }}</td>

                            <td>

                                <form action="{{ route('admin.tags.restore', $tag->id) }}" method="POST" class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.tags.forceDelete', $tag->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete permanently?')">

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

                            <td colspan="5" class="text-center">

                                Trash Empty

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $trashTags->links() }}

        </div>

    </div>

@endsection
