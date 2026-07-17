@extends('admin.layouts.master')

@section('title', 'Users')

@section('content')

    <h3 class="mb-4">
        Users
    </h3>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
            Add User
        </a>

        <a href="{{ route('admin.users.trash') }}" class="btn btn-warning mb-3">
            Trash
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profile Image</th>
                        <th>Role</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" width="45" height="45"
                                        class="rounded-circle">
                                @else
                                    <img src="{{ asset('images/user.png') }}" width="45" height="45"
                                        class="rounded-circle">
                                @endif

                            </td>

                            <td>
                                {{ $user->roles->pluck('name')->implode(', ') }}
                            </td>

                            <td>

                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">

                                    Edit

                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No users found.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $users->links() }}

        </div>
    </div>

@endsection
