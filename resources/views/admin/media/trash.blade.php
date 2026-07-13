@extends('admin.layouts.master')

@section('title', 'Trash Media')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>Trash Media</h3>

        <a href="{{ route('admin.media.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>File Name</th>

                        <th>File Type</th>

                        <th>File Size</th>

                        <th>Deleted At</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($trashMedia as $media)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                <img src="{{ asset('storage/' . $media->file_path) }}" width="80" class="img-thumbnail">

                            </td>

                            <td>{{ $media->file_name }}</td>

                            <td>{{ $media->file_type }}</td>

                            <td>

                                {{ number_format($media->file_size / 1024, 2) }} KB

                            </td>

                            <td>

                                {{ $media->deleted_at->format('d M, Y h:i A') }}

                            </td>

                            <td>

                                <form action="{{ route('admin.media.restore', $media->id) }}" method="POST" class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.media.forceDelete', $media->id) }}" method="POST"
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

                            <td colspan="7" class="text-center">

                                Trash is empty.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">

                {{ $trashMedia->links() }}

            </div>

        </div>

    </div>

@endsection
