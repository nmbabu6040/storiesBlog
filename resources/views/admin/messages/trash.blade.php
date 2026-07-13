@extends('admin.layouts.master')

@section('title', 'Trash Contact Messages')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>Trash Contact Messages</h3>

        <a href="{{ route('admin.messages.index') }}" class="btn btn-primary">

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

                        <th>Email</th>

                        <th>Subject</th>

                        <th>Deleted At</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($trashMessages as $message)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $message->name }}</td>

                            <td>{{ $message->email }}</td>

                            <td>{{ $message->subject }}</td>

                            <td>{{ $message->deleted_at->format('d M Y h:i A') }}</td>

                            <td>

                                <form action="{{ route('admin.messages.restore', $message->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.messages.forceDelete', $message->id) }}" method="POST"
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

                            <td colspan="6" class="text-center">

                                Trash is empty.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $trashMessages->links() }}

        </div>

    </div>

@endsection
