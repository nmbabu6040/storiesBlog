@extends('admin.layouts.master')

@section('title', 'Trash Advertisements')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>Trash Advertisements</h3>

        <a href="{{ route('admin.advertisements.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Title</th>

                        <th>Position</th>

                        <th>Type</th>

                        <th>Image</th>

                        <th>Deleted At</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($advertisements as $advertisement)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $advertisement->title }}</td>

                            <td>{{ ucfirst($advertisement->position) }}</td>

                            <td>{{ ucfirst($advertisement->type) }}</td>

                            <td>

                                @if ($advertisement->image)
                                    <img src="{{ asset('storage/' . $advertisement->image) }}" width="80">
                                @endif

                            </td>

                            <td>

                                {{ $advertisement->deleted_at->format('d M, Y h:i A') }}

                            </td>

                            <td>

                                <form action="{{ route('admin.advertisements.restore', $advertisement->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.advertisements.forceDelete', $advertisement->id) }}"
                                    method="POST" class="d-inline" onsubmit="return confirm('Delete permanently?')">

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

            {{ $advertisements->links() }}

        </div>

    </div>

@endsection
