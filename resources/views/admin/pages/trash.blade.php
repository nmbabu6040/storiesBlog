@extends('admin.layouts.master')

@section('title', 'Trash Pages')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>

            Trash Pages

        </h3>

        <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Banner</th>

                        <th>Title</th>

                        <th>Deleted At</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($pages as $page)
                        <tr>

                            <td>

                                {{ $loop->iteration }}

                            </td>

                            <td>

                                @if ($page->banner_image)
                                    <img src="{{ asset('storage/' . $page->banner_image) }}" width="80">
                                @endif

                            </td>

                            <td>

                                {{ $page->title }}

                            </td>

                            <td>

                                {{ $page->deleted_at->format('d M, Y h:i A') }}

                            </td>

                            <td>

                                <form action="{{ route('admin.pages.restore', $page->id) }}" method="POST" class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.pages.forceDelete', $page->id) }}" method="POST"
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

            {{ $pages->links() }}

        </div>

    </div>

@endsection
