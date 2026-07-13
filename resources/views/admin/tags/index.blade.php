@extends('admin.layouts.master')

@section('title', 'Tags')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>Tags</h3>

        <div>

            <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">

                Add Tag

            </a>

            <a href="{{ route('admin.tags.trash') }}" class="btn btn-warning">

                Trash

            </a>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Name</th>

                        <th>Slug</th>

                        <th>Status</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($tags as $tag)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $tag->name }}</td>

                            <td>{{ $tag->slug }}</td>

                            <td>

                                @if ($tag->status)
                                    <span class="badge bg-success">

                                        Active

                                    </span>
                                @else
                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-primary">

                                    Edit

                                </a>

                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Move to trash?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No Tags Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $tags->links() }}

        </div>

    </div>

@endsection
