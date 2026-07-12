@extends('admin.layouts.master')

@section('title', 'Categories')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">

        <h3>Categories</h3>

        <div class='d-flex gap-2'>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">

                Add Category

            </a>

            <a href="{{ route('admin.categories.trash') }}" class="btn btn-warning">

                Trash

            </a>
        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($categories as $category)
                        <tr>

                            <td>{{ $category->id }}</td>

                            <td>

                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" width="60">
                                @endif

                            </td>

                            <td>{{ $category->name }}</td>

                            <td>{{ $category->slug }}</td>

                            <td>

                                @if ($category->status)
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
                                {{ $category->created_at->format('d M Y') }}
                            </td>
                            <td>

                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="btn btn-sm btn-warning">

                                    Edit

                                </a>

                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                        class="btn btn-sm btn-danger">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center">

                                No Category Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
