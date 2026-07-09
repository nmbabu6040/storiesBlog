@extends('admin.layouts.master')

@section('title', 'Advertisements')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4>Advertisements</h4>

        <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary">

            Add Advertisement

        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <div class="card">

        <div class="card-body table-responsive">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Title</th>

                        <th>Position</th>

                        <th>Type</th>

                        <th>Status</th>

                        <th width="150">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($advertisements as $ad)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $ad->title }}</td>

                            <td>{{ ucwords(str_replace('_', ' ', $ad->position)) }}</td>

                            <td>{{ ucfirst($ad->type) }}</td>

                            <td>

                                @if ($ad->status)
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

                                <a href="{{ route('admin.advertisements.edit', $ad) }}" class="btn btn-sm btn-warning">

                                    Edit

                                </a>

                                <form action="{{ route('admin.advertisements.destroy', $ad) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button onclick="return confirm('Delete Advertisement?')" class="btn btn-sm btn-danger">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No Advertisements Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $advertisements->links() }}

        </div>

    </div>

@endsection
