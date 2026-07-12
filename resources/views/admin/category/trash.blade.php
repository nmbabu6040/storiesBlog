@extends('admin.layouts.master')

@section('title', 'Trash Categories')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>

            Trash Categories

        </h3>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

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

                    @forelse($categories as $category)
                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                {{ $category->name }}

                            </td>

                            <td>

                                {{ $category->slug }}

                            </td>

                            <td>

                                {{ $category->deleted_at->format('d M, Y h:i A') }}

                            </td>

                            <td>

                                <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.categories.forceDelete', $category->id) }}" method="POST"
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

                                Trash is empty.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $categories->links() }}

        </div>

    </div>

@endsection
