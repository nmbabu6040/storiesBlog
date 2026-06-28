@extends('admin.layouts.master')

@section('title', 'Pages')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4>Pages</h4>

        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">

            Add Page

        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Title</th>

                        <th>Slug</th>

                        <th>Status</th>

                        <th width="170">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pages as $page)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $page->title }}</td>

                            <td>{{ $page->slug }}</td>

                            <td>

                                @if ($page->status)
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

                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this page?')" class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No Pages Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
